<?php

/**
 * Reminder -
 *
 * Example:
 *
 *
 * @author      Alexis <293287 @ supinfo.com>
 * @version     1.0
 * @access      public
 */
class Reminders extends BaseClass {

    /**
     * getAll - Get all reminders.
     *
     * @param   int     $user_id    User's id
     * @return  array               Reminders of the user
     * @access  public
     */
    public function getAll($user_id) {

        $sql = "SELECT
                    reminder_id,
                    user_id,
                    reminder_cat_id,
                    alarm_id,
                    name,
                    description
                FROM
                    reminders
                WHERE
                    user_id = :user_id";

        return $this->sendQuery($sql, ["user_id" => (int) $user_id]);
    }
}