<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clientspecificindependencedeclaration extends Model
{
    use HasFactory;

    protected $fillable = ['year','subsidiaries','subsidiariesother','financial','financialother','outside','outsideother','client','clientother'
,'authority','authorityother','underwriter','underwriterother','trustee','trusteeother','spouse','spouseother','compromise','compromiseother',
'litigation','litigationother','relative','relativeother','type','createdby','partner'
];

    protected $table = 'annual_independence_declarations';
}
