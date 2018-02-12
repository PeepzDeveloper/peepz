<?php
require_once '../functions/functionmain.php';

$companyIdSql = <<<SQL
SELECT companyid FROM contacts WHERE contactid = $_SESSION[userid]; 
SQL;

$companyId = DB($companyIdSql);

$findAddressSql = <<<SQL
SELECT addressid FROM address WHERE street = '$_POST[address]';
SQL;

$addressId = DB($findAddressSql);

if (empty($addressId)) {
    $latlng = explode(',', $_POST['coordinates']);
    $insertAddressSql = <<<SQL
INSERT INTO address (
    street,
    lat,
    lng
) VALUES (
    '$_POST[address]',
    '$latlng[0]',
    '$latlng[1]'
)
SQL;
    DB($insertAddressSql);

    $addressId = DB($findAddressSql);
}



$createJobSql = <<<SQL
INSERT INTO jobs (
    contactid,
    eventid,
    title,
    description,
    addressid,
    stafftypeid,
    ratetypeid,
    negotiable,
    suggestedrate,
    approvedrate,
    statusid,
    datestart,
    dateend,
    timestart,
    timeend,
    companyid,
    changedby
) VALUES (
    $_SESSION[userid],
    NULL,
    '$_POST[title]',
    '$_POST[description]',
    $addressId,
    $_POST[selstafftype],
    $_POST[ratetypeid],
    'no',
    '$_POST[suggestedrate]',
    NULL,
    1,
    '$_POST[datestart]',
    '$_POST[dateend]',
    '$_POST[timestart]',
    '$_POST[timeend]',
    $companyId,
    $_SESSION[userid]
);
SQL;

DB($createJobSql);
