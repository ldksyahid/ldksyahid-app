<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Queue\DatabaseQueue;
use Illuminate\Queue\Jobs\DatabaseJobRecord;
use Illuminate\Queue\Connectors\ConnectorInterface;
use Illuminate\Database\ConnectionResolverInterface;
use Illuminate\Support\Carbon;

// ---------------------------------------------------------------------------
// Job Record — maps custom column names to Laravel's expected property names
// ---------------------------------------------------------------------------
class TrJobQueueRecord extends DatabaseJobRecord
{
    private const COLUMN_MAP = [
        'id'          => 'ID',
        'reserved_at' => 'reservedDate',
        'available_at' => 'availableDate',
        'created_at'  => 'createdDate',
    ];

    public function touch()
    {
        $this->record->reservedDate = $this->currentTime();
        return $this->record->reservedDate;
    }

    public function __get($key)
    {
        $actualKey = self::COLUMN_MAP[$key] ?? $key;
        return $this->record->{$actualKey};
    }
}

// ---------------------------------------------------------------------------
// Queue Driver — overrides queries to use custom column names
// ---------------------------------------------------------------------------
class TrJobQueueDriver extends DatabaseQueue
{
    protected function buildDatabaseRecord($queue, $payload, $availableAt, $attempts = 0)
    {
        return [
            'queue'        => $queue,
            'attempts'     => $attempts,
            'reservedDate' => null,
            'availableDate' => $availableAt,
            'createdDate'  => $this->currentTime(),
            'payload'      => $payload,
        ];
    }

    protected function getNextAvailableJob($queue)
    {
        $job = $this->database->table($this->table)
                    ->lock($this->getLockForPopping())
                    ->where('queue', $this->getQueue($queue))
                    ->where(function ($query) {
                        $this->isAvailable($query);
                        $this->isReservedButExpired($query);
                    })
                    ->orderBy('ID', 'asc')
                    ->first();

        return $job ? new TrJobQueueRecord((object) $job) : null;
    }

    protected function isAvailable($query)
    {
        $query->where(function ($query) {
            $query->whereNull('reservedDate')
                  ->where('availableDate', '<=', $this->currentTime());
        });
    }

    protected function isReservedButExpired($query)
    {
        $expiration = Carbon::now()->subSeconds($this->retryAfter)->getTimestamp();

        $query->orWhere(function ($query) use ($expiration) {
            $query->where('reservedDate', '<=', $expiration);
        });
    }

    protected function markJobAsReserved($job)
    {
        $this->database->table($this->table)->where('ID', $job->ID)->update([
            'reservedDate' => $job->touch(),
            'attempts'     => $job->increment(),
        ]);

        return $job;
    }

    public function deleteReserved($queue, $id)
    {
        $this->database->transaction(function () use ($id) {
            if ($this->database->table($this->table)->lockForUpdate()->where('ID', $id)->first()) {
                $this->database->table($this->table)->where('ID', $id)->delete();
            }
        });
    }

    public function deleteAndRelease($queue, $job, $delay)
    {
        $this->database->transaction(function () use ($queue, $job, $delay) {
            if ($this->database->table($this->table)->lockForUpdate()->where('ID', $job->getJobId())->first()) {
                $this->database->table($this->table)->where('ID', $job->getJobId())->delete();
            }

            $this->release($queue, $job->getJobRecord(), $delay);
        });
    }
}

// ---------------------------------------------------------------------------
// Connector — registers TrJobQueueDriver as the queue backend
// ---------------------------------------------------------------------------
class TrJobQueueConnector implements ConnectorInterface
{
    protected $connections;

    public function __construct(ConnectionResolverInterface $connections)
    {
        $this->connections = $connections;
    }

    public function connect(array $config)
    {
        return new TrJobQueueDriver(
            $this->connections->connection($config['connection'] ?? null),
            $config['table'],
            $config['queue'],
            $config['retry_after'] ?? 60,
            $config['after_commit'] ?? null
        );
    }
}

// ---------------------------------------------------------------------------
// Eloquent Model — for querying/displaying jobs (e.g. admin panel)
// ---------------------------------------------------------------------------
class TrJobQueue extends Model
{
    protected $table      = 'tr_job_queue';
    protected $primaryKey = 'ID';
    public    $timestamps = false;

    protected $fillable = [
        'queue',
        'payload',
        'attempts',
        'reservedDate',
        'availableDate',
        'createdDate',
    ];
}
