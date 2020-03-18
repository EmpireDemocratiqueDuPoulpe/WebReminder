<?php

/**
 * ReminderCat -
 *
 * Example:
 *
 *
 * @author      Alexis <293287 @ supinfo.com>
 * @version     1.0
 * @access      public
 */
class RemindersCat extends BaseClass {

    /**
     * getAll - Get all reminders categories.
     *
     * @param   int     $user_id    User's id
     * @return  array               Reminders categories of the user
     * @access  public
     */
    public function getAll($user_id) {

        $sql = "SELECT
                    reminder_cat_id,
                    user_id,
                    name,
                    description,
                    color
                FROM
                    reminders_cat
                WHERE
                    user_id = :user_id";

        return $this->sendQuery($sql, ["user_id" => (int) $user_id]);
    }
}