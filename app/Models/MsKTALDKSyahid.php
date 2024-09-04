<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Models\LkFaculty;
use App\Models\LkGeneration;
use App\Models\LkMajor;
use App\Services\GoogleDrive;
use Illuminate\Support\Facades\File;

class MsKTALDKSyahid extends Model
{
    public static $pathKtaGDrive = '1gTa-VH6WTPFNsHxjCO0UbZVqnTpWr6t4';

    protected $table = 'ms_ktaldksyahid';

    protected $fillable = [
        'fullName',
        'gender',
        'nim',
        'facultyID',
        'majorID',
        'generationID',
        'memberNumber',
        'slogan',
        'background',
        'email',
        'linkedIn',
        'instagram',
        'photo',
        'linkProfile',
        'gdrive_id'
    ];

    public function getFaculty()
    {
        return $this->belongsTo(LkFaculty::class, 'facultyID', 'id');
    }

    public function getMajor()
    {
        return $this->belongsTo(LkMajor::class, 'majorID', 'id');
    }

    public function getGeneration()
    {
        return $this->belongsTo(LkGeneration::class, 'generationID', 'id');
    }

    public static function createKTA(Request $request)
    {
        $uploadResult = [];
        if (!empty($request->photo)) {
            $gdriveService = new GoogleDrive(self::$pathKtaGDrive);

            $fileName = time() . '_kta-ldksyahid_' . $request->file('photo')->getClientOriginalName();
            $filePath = self::$pathKtaGDrive . '/' . $fileName;

            $uploadResult = $gdriveService->uploadImage($request->file('photo'), $fileName, $filePath);
        }

        return self::create([
            'fullName' => $request['fullName'],
            'gender' => $request['gender'],
            'nim' => $request['nim'],
            'facultyID' => $request['faculty'],
            'majorID' => $request['major'],
            'generationID' => $request['generation'],
            'memberNumber' => $request['memberNumber'],
            'slogan' => $request['slogan'],
            'background' => $request['background'],
            'email' => $request['email'],
            'linkedIn' => $request['linkedIn'],
            'instagram' => $request['instagram'],
            'photo' => !empty($uploadResult) ? $uploadResult['fileName'] : null,
            'gdrive_id' => !empty($uploadResult) ? $uploadResult['gdriveID'] : null,
            'linkProfile' => $request['linkProfile'],
        ]);
    }

    public static function updateKTA(Request $request, $id)
    {
        $ktaData = Self::where('id', $id)->first();

        if ($request->file('photo')) {
            $gdriveService = new GoogleDrive(self::$pathKtaGDrive);

            $fileName = time() . '_kta-ldksyahid_' . $request->file('photo')->getClientOriginalName();
            $filePath = self::$pathKtaGDrive . '/' . $fileName;

            $uploadResult = $gdriveService->uploadImage($request->file('photo'), $fileName, $filePath);

            $oldGdriveID = $ktaData->gdrive_id;

            if ($oldGdriveID) {
                $gdriveService->deleteImage($oldGdriveID);
            }

            $ktaData->update([
                'photo' => $uploadResult['fileName'],
                'gdrive_id' => $uploadResult['gdriveID'],
            ]);
        }

        return self::where('id', $id)->update([
            'fullName' => $request['fullName'],
            'gender' => $request['gender'],
            'nim' => $request['nim'],
            'facultyID' => $request['faculty'],
            'majorID' => $request['major'],
            'generationID' => $request['generation'],
            'memberNumber' => $request['memberNumber'],
            'slogan' => $request['slogan'],
            'background' => $request['background'],
            'email' => $request['email'],
            'linkedIn' => $request['linkedIn'],
            'instagram' => $request['instagram'],
            'linkProfile' => $request['linkProfile']
        ]);
    }


    public static function destroyKTA($id)
    {
        $ktaData = MsKTALDKSyahid::find($id);
        $gdriveService = new GoogleDrive(self::$pathKtaGDrive);
        if ($ktaData) {
            if ($ktaData->gdrive_id) {
                $gdriveService->deleteImage($ktaData->gdrive_id);
            }
            $ktaData->delete();
        }
    }

}
