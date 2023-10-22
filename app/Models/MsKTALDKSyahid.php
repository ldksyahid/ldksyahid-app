<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Models\LkFaculty;
use App\Models\LkGeneration;
use App\Models\LkMajor;
use Illuminate\Support\Facades\File;

class MsKTALDKSyahid extends Model
{
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
        if (!empty($request->photo)) {
            $filenamePhoto = time().$request->file('photo')->getClientOriginalName();
            $pathPhoto = $request->file('photo')->storeAs('Images/uploads/kta',$filenamePhoto);
        } else {
            $pathPhoto = null;
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
            'photo' => $pathPhoto,
            'linkProfile' => $request['linkProfile'],
        ]);
    }

    public static function updateKTA(Request $request, $id)
    {
        $ktaData = Self::where('id', $id)->first();

        if ($request->file('photo')) {
            $filenamePhoto = time() . $request->file('photo')->getClientOriginalName();
            $pathPhoto = $request->file('photo')->storeAs('Images/uploads/kta', $filenamePhoto);
            if ($ktaData->photo) {
                unlink(public_path($ktaData->photo));
            }
            self::where('id', $id)->update([
                'photo' => $pathPhoto,
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
        if ($ktaData) {
            if (!empty($ktaData->photo)) {
                File::delete($ktaData->photo);
            }
            $ktaData->delete();
        }
    }

}
