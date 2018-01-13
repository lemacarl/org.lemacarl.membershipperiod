DROP TABLE IF EXISTS `civicrm_membershipperiod`;

-- /*******************************************************
-- *
-- * civicrm_membershipperiod
-- *
-- * Custom membership period entity
-- *
-- *******************************************************/
CREATE TABLE `civicrm_membershipperiod` (


     `id` int unsigned NOT NULL AUTO_INCREMENT  COMMENT 'Unique MembershipPeriod ID',
     `membership_id` int unsigned    COMMENT 'FK to Membership',
     `contribution_id` int unsigned NULL   COMMENT 'FK to Contribution',
     `start_date` date    COMMENT 'Beginning of current uninterrupted membership period.',
     `end_date` date    COMMENT 'Current membership period expire date.' 
,
        PRIMARY KEY (`id`)
 
 
,          CONSTRAINT FK_civicrm_membershipperiod_membership_id FOREIGN KEY (`membership_id`) REFERENCES `civicrm_membership`(`id`) ON DELETE CASCADE,          CONSTRAINT FK_civicrm_membershipperiod_contribution_id FOREIGN KEY (`contribution_id`) REFERENCES `civicrm_contribution`(`id`) ON DELETE SET NULL  
)  ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci  ;
