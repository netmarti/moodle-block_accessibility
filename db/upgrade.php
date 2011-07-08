<?php
// This file keeps track of upgrades to
// the accessibility block
//
// Sometimes, changes between versions involve
// alterations to database structures and other
// major things that may break installations.
//
// The upgrade function in this file will attempt
// to perform all the necessary actions to upgrade
// your older installtion to the current version.
//
// If there's something it cannot do itself, it
// will tell you what you need to do.
//
// The commands in here will all be database-neutral,
// using the functions defined in lib/ddllib.php

function xmldb_block_accessibility_upgrade($oldversion=0) {

    global $CFG, $THEME, $DB;

    $dbman = $DB->get_manager();

    $result = true;

/// And upgrade begins here. For each one, you'll need one
/// block of code similar to the next one. Please, delete
/// this comment lines once this file start handling proper
/// upgrade code.

    if ($result && $oldversion < 2009082500) {

    /// Define field colourscheme to be added to accessibility
        $table = new XMLDBTable('accessibility');
        $field = new XMLDBField('colourscheme');
        $field->setAttributes(XMLDB_TYPE_INTEGER, '1', XMLDB_UNSIGNED, null, null, null, null, null, 'fontsize');

    /// Launch add field colourscheme
        $result = $result && add_field($table, $field);
    }

    if ($result && $oldversion < 2009071000) {

    /// Changing type of field fontsize on table accessibility to number
        $table = new XMLDBTable('accessibility');
        $field = new XMLDBField('fontsize');
        $field->setAttributes(XMLDB_TYPE_NUMBER, '4, 1', XMLDB_UNSIGNED, null, null, null, null, null, 'userid');

    /// Launch change of type for field fontsize
        $result = $result && change_field_type($table, $field);
    }

    if ($oldversion < 2010121500) {

        // Define field autoload_atbar to be added to accessibility
        $table = new xmldb_table('accessibility');
        $field = new xmldb_field('autoload_atbar', XMLDB_TYPE_INTEGER, '1', XMLDB_UNSIGNED, XMLDB_NOTNULL, null, '0', 'colourscheme');

        // Conditionally launch add field autoload_atbar
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // accessibility savepoint reached
        upgrade_block_savepoint(true, 2010121500, 'accessibility');
    }


    return $result;

}

?>
