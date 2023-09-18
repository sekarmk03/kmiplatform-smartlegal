<?php

namespace Modules\Smartlegal\Entities;

use App\Models\DepartmentModel;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mandatory extends Model
{
    use HasFactory;
    protected $connection = 'smartlegal';
    protected $table = 'mmandatories';

    const CREATED_AT = 'dtmCreatedAt';
    const UPDATED_AT = 'dtmUpdatedAt';
    const DELETED_AT = 'dtmDeletedAt';
    protected $primaryKey = 'intMandatoryID';
    protected $fillable = ['intDocID', 'intTypeID', 'intPICDeptID', 'intPICUserID', 'intVariantID', 'dtmPublishDate', 'dtmExpireDate', 'intIssuerID', 'intReminderPeriod', 'txtLocationFilling', 'intFileID', 'intRenewalCost', 'intCostCenterID', 'txtNote', 'txtTerminationNote', 'intCreatedBy'];

    public static function rules()
    {
        return [
            'intTypeID' => 'required|numeric',
            'intPICDeptID' => 'required|numeric',
            'intPICUserID' => 'required|numeric',
            'intVariantID' => 'required|numeric',
            'dtmPublishDate' => 'required',
            'dtmExpireDate' => 'nullable',
            'intIssuerID' => 'required|numeric',
            'intReminderPeriod' => 'nullable|numeric',
            'txtLocationFilling' => 'required|string|max:50',
            'intFileID' => 'required|numeric',
            'intRenewalCost' => 'nullable|numeric',
            'intCostCenterID' => 'required|numeric',
            'txtNote' => 'nullable|string|max:1000',
            'txtTerminationNote' => 'nullable|string|max:1000'
        ];
    }

    public static function attributes(){
        return [
            'intTypeID' => 'Document Type',
            'intPICDeptID' => 'PIC Department',
            'intPICUserID' => 'PIC Name',
            'intVariantID' => 'Document Variant',
            'dtmPublishDate' => 'Publish Date',
            'dtmExpireDate' => 'Expire Date',
            'intIssuerID' => 'Document Issuer',
            'intReminderPeriod' => 'Reminder Period',
            'txtLocationFilling' => 'Location Filling',
            'intFileID' => 'File',
            'intRenewalCost' => 'Renewal Cost',
            'intCostCenterID' => 'Cost Center',
            'txtNote' => 'Document Note',
            'txtTerminationNote' => 'Termination Note'
        ];
    }

    public function document() {
        return $this->belongsTo(Document::class, 'intDocID', 'intDocID');
    }

    public function type() {
        return $this->belongsTo(DocType::class, 'intTypeID', 'intDocTypeID');
    }

    public function picdept() {
        return $this->belongsTo(DepartmentModel::class, 'intPICDeptID', 'intDepartment_ID');
    }

    public function picuser() {
        return $this->belongsTo(User::class, 'intPICUserID', 'id');
    }

    public function variant() {
        return $this->belongsTo(DocVariant::class, 'intVariantID', 'intDocVariantID');
    }

    public function issuer() {
        return $this->belongsTo(Issuer::class, 'intIssuerID', 'intIssuerID');
    }

    public function file() {
        return $this->belongsTo(File::class, 'intFileID', 'intFileID');
    }

    public function costcenter() {
        return $this->belongsTo(DepartmentModel::class, 'intCostCenterID', 'intDepartment_ID');
    }

    public function createdby() {
        return $this->belongsTo(User::class, 'intCreatedBy', 'id');
    }
}
