<?php
$data_read = file_get_contents('/Users/jose/dev/osn_mappingdata/data/data.0.json');
$data = json_decode($data_read); //var_dump( count($data) );

$mergedData = [];

// 1) pull in 0 sheet with all Rows
foreach ($data as $key => $d)
{
  //tweak and wipe fields
  if($d->id > 0)
  {
    @$mergedData[$d->id]->id = $d->id;
    $mergedData[$d->id]->name = $d->name;

    $mergedData[$d->id]->category = $d->{'mainCategoryOfStakeholder
(educationalInstitution,ServiceProvider,Investor,Government,Lender,Association,Foundation)'};
    $mergedData[$d->id]->subcategory = $d->{'subCategory(ifApplicable):
[university,CommunityCollege],[training,Marketing,Legal,Financial],[angel( $10k — $250k),Seed($50k — $1.5m),Vc ($3m — $15m)],PrivateEquity],[city,County,State,Federal],[loanRanges],[chamberOfCommerce,MembershipOrg.]'};
    $mergedData[$d->id]->target = $d->{'targetBusinessSize(small,Mid,High,All)'};
    $mergedData[$d->id]->industry = $d->{'targetIndustryServed(tech,Food,Cannabis,Etc.)'};

    $tmpStage = $d->{'businessesThisEntityHelpsAreInTheFollowingBusinessStage(s):Inspire,Plan,Launch,Sustain,Grow,Exit?'};
    if(!is_null($tmpStage) || !empty($tmpStage))
    {
      $tmpStageStrip = str_replace(' ', '', $tmpStage);
      $mergedData[$d->id]->stage = explode(",",$tmpStageStrip);
    }

    //only keep digits and commas, and put into array
    $enablerTypes = [1 => 'personal', 2 => 'financial', 3 => 'business', 4 => 'environmental'];
    $tmpEnablerSplit = explode(",",trim($d->{'enablerType:Personal,Financial,Business,Environment'}));
    $tmpEnablerFiltered = filter_var_array($tmpEnablerSplit, FILTER_SANITIZE_NUMBER_INT); //var_dump( $tmpEnablerFiltered );
    if(!is_null($tmpEnablerFiltered) && count($tmpEnablerFiltered) > 0)
    {
      foreach($tmpEnablerFiltered as $tmpEFKey => $tmpEFVal)
      {
        $mergedData[$d->id]->enablerType[$tmpEFKey] = $enablerTypes[$tmpEFVal];
      }
    }
    //$mergedData[$d->id]->enablerType = array_intersect($tmpEnablerFiltered, $enablerTypes); //var_dump( $mergedData[$d->id]->enablerType );

    $mergedData[$d->id]->website = $d->websiteOfStakeholder;
    $mergedData[$d->id]->twitter = $d->twitterHandle;
    $mergedData[$d->id]->yearsInOakland = $d->yearsInOakland;
    $mergedData[$d->id]->addressStreet = $d->physicalAddressOfStakeholder;
    $mergedData[$d->id]->addressCity = $d->city;
    $mergedData[$d->id]->addressZip = $d->zipCode;
    if( !empty($d->physicalAddressOfStakeholder) && !empty($d->city) ){
      $mergedData[$d->id]->address = $d->physicalAddressOfStakeholder .' '. $d->city;
    }
    $mergedData[$d->id]->about = $d->about;
  }
}

// 1) pull in 5 sheet with more data
$data5_read = file_get_contents('/Users/jose/dev/osn_mappingdata/data/data.5.json');
$data5 = json_decode($data5_read); //var_dump( $data_5_read );

// 1) pull in 0 sheet with all Rows
foreach ($data5 as $key5 => $d5)
{
  //merge in empty fields
  if($d5->id > 0)
  {
    //website
    if( empty($mergedData[$d5->id]->website) || !isset($mergedData[$d5->id]->website) || is_null($mergedData[$d5->id]->website) )
    {
      @$mergedData[$d5->id]->website = $d5->websiteOfStakeholder;
    }

    //twitter
    if( empty($mergedData[$d5->id]->twitter) || !isset($mergedData[$d5->id]->twitter) || is_null($mergedData[$d5->id]->twitter) )
    {
      $mergedData[$d5->id]->twitter = $d5->twitterHandle;
    }

    //about
    if( empty($mergedData[$d5->id]->about) || !isset($mergedData[$d5->id]->about) || is_null($mergedData[$d5->id]->about) )
    {
      $mergedData[$d5->id]->about = $d5->about;
    }


  }
}

header('Content-Type: application/json');
echo json_encode( $mergedData );

