<?php

class m130916_100007_initial_migration_for_ophtroperationanaesthetic extends CDbMigration
{
    public function up() {

// Get the event group for ‘Treatment events’

        $group = $this->dbConnection->createCommand()
            ->select('id')
            ->from('event_group')
            ->where('name=:name',array(':name'=>'Treatment events'))
            ->queryRow();

// Create the new Operation anaesthetic event_type

        $this->insert('event_type', array(
            'name' => 'Operation anaesthetic',
            'event_group_id' => $group['id'],
            'class_name' => 'OphTrOperationanaesthetic'
        ));

// Get the newly created event type

        $event_type = $this->dbConnection->createCommand()
            ->select('id')
            ->from('event_type')
            ->where('name=:name', array(':name'=>'Operation anaesthetic'))
            ->queryRow();

// Create an element for the new event type called ElementDetails

        $this->insert('element_type', array(
            'name' => 'Details',
            'class_name' => 'ElementDetails',
            'event_type_id' => $event_type['id'],
            'display_order' => 1,
            'default' => 1,
        ));

// Create a table to store the ElementDetails element

        $this->createTable('et_ophtroperationanaesthetic_details', array(
            'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
            'event_id' => 'int(10) unsigned NOT NULL',
            'anaesthetist_id' => 'int(10) unsigned',
            'comments' => 'varchar(255)',
            'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
            'last_modified_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
            'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
            'created_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
            'PRIMARY KEY (`id`)',
            'KEY `et_ophtroperationanaesthetic_details_event_id_fk` (`event_id`)',
            'KEY `et_ophtroperationanaesthetic_details_anaesthetist_id_fk` (`anaesthetist_id`)',
            'KEY `et_ophtroperationanaesthetic_details_created_user_id_fk` (`created_user_id`)',
            'KEY `et_ophtroperationanaesthetic_details_last_modified_user_id_fk` (`last_modified_user_id`)',
            'CONSTRAINT `et_ophtroperationanaesthetic_details_event_id_fk` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`)',
            'CONSTRAINT `et_ophtroperationanaesthetic_details_anaesthetist_id_fk` FOREIGN KEY (`anaesthetist_id`) REFERENCES `consultant` (`id`)',
            'CONSTRAINT `et_ophtroperationanaesthetic_details_created_user_id_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
            'CONSTRAINT `et_ophtroperationanaesthetic_details_last_modified_user_id_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
        ), 'ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin');

    }

    public function down() {
// Drop the table created for ElementDetails

        $this->dropTable('et_ophtroperationanaesthetic_details');


// Find the event type

        $event_type = $this->dbConnection->createCommand()
            ->select('id')
            ->from('event_type')
            ->where('name=:name', array(':name'=>'Operation anaesthetic'))
            ->queryRow();

// Find the ElementDetails element type

        $element_type = $this->dbConnection->createCommand()
            ->select('id')
            ->from('element_type')
            ->where('name=:name and event_type_id=:event_type_id',array(
                ':name'=>'Details',
                ':event_type_id'=>$event_type['id']
            ))->queryRow();

// Delete the ElementDetails element type

        $this->delete('element_type','id='.$element_type['id']);

// Delete the event type

        $this->delete('event_type','id='.$event_type['id']);

    }

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}