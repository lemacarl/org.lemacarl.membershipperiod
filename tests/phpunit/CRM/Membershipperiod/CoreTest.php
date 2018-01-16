<?php

use CRM_Membershipperiod_ExtensionUtil as E;
use Civi\Test\HeadlessInterface;

/**
 * Test the core functionality
 *
 * @group headless
 * @group legacy
 */
class CRM_MembershipPeriod_CoreTest extends \CiviUnitTestCase implements HeadlessInterface {

  private $membership;

  public function setUpHeadless() {
  }

  public function setUp() {
    parent::setUp();
    $this->quickCleanup( array( 'civicrm_membershipperiod' ) );
    $this->setUpTestData();
  }

  public function tearDown() {
    parent::tearDown();
  }

  public function testInsertMembershipPeriod() {
    $m = $this->membership;

    // Mock object
    $object = Mockery::spy();

    // Populate object
    $object->id = $m['id'];
    $object->contact_id = $m['values'][ $m['id'] ]['contact_id'];
    $object->start_date = $m['values'][ $m['id'] ]['start_date'];
    $object->end_date = $m['values'][ $m['id'] ]['end_date'];

    $core = new CRM_Membershipperiod_Core();
    $core->insertMembershipPeriod( 'create', $object );

    $this->assertDBQuery( 1, "SELECT count(*) FROM civicrm_membershipperiod WHERE membership_id = {$m['id']}" );

    // Edit object
    $object->start_date = '20180101';
    $core->insertMembershipPeriod( 'edit', $object );

    $this->assertDBQuery( '2018-01-01', "SELECT start_date FROM civicrm_membershipperiod WHERE membership_id = {$m['id']}" );

  }

  public function setUpTestData() {
    // Create contact
    $contact = civicrm_api3( 'Contact', 'create', array(
      'first_name'    => 'John',
      'last_name'     => 'Doe',
      'contact_type'  => 'Individual'
    ) );

    // Create organization
    $organization = civicrm_api3( 'Contact', 'create', array(
      'organization_name' => 'test organization',
      'contact_type'      => 'Organization'
    ) );

    // Create domain
    $domain = civicrm_api3( 'Domain', 'create', array(
      'name'            => 'test domain',
      'domain_version'  => 'test version'
    ) );

    // Create financial type
    $financial_type = civicrm_api3( 'FinancialType', 'create', array(
     'name'       => 'test financial type',
     'is_active'  => 1
    ) );

    // Create membership type
    $membership_type = civicrm_api3( 'MembershipType', 'create', array(
      'name'                  => 'test membership type',
      'domain_id'             => $domain['id'],
      'financial_type_id'     => $financial_type['id'],
      'member_of_contact_id'  => $organization['id'],
      'duration_unit'         => 'month',
      'duration_interval'     => 12,
      'period_type'           => 'rolling',
    ) );
    
    // Create new membership 
    $this->membership = civicrm_api3( 'Membership', 'create', array(
      'membership_type_id'  => $membership_type['id'],
      'contact_id'          => $contact['id'],
      'status_id'           => 1,
    ) );
  }
}
