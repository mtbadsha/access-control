<?php

/**
 * Created by PhpStorm.
 * User: bfkabir
 * Date: 4/29/15
 * Time: 3:41 PM
 */

namespace App\lib;

class utility {
    /*
     *
     * convert date format
     * input date format (mm/dd/yyyy)
     * output date format (yyyy-mm-dd)
     */

    public static function dateConvert($date) {
        //echo $date; exit;
        if ($date != '') {
            $date_array = explode('-', $date);
            if (strlen($date_array[2]) < 4) {
                return '20' . $date_array[2] . '-' . $date_array[0] . '-' . $date_array[1];
            } else {
                return $date_array[2] . '-' . $date_array[0] . '-' . $date_array[1];
            }
        } else {
            return '';
        }
    }

    public static function dateConvert2($date)
    {
        //echo substr($date, 0, 1);
        if ($date != ''&&substr($date, 0, 1)!="#") {
            $date_array = explode('-', $date);
            if (strlen($date_array[2]) < 4) {
                if($date_array[2]<30)
                    $date2 =  '20' . $date_array[2] . '-' . $date_array[0] . '-' . $date_array[1];
                else
                    $date2 =  '19' . $date_array[2] . '-' . $date_array[0] . '-' . $date_array[1];
                $date3 = \DateTime::createFromFormat('Y-d-M', $date2);
                return $date3->format('Y-m-d');
            } else {
                $date3 = \DateTime::createFromFormat('d-M-Y', $date);
                return $date3->format('Y-m-d');
            }
        } else {
            return '';
        }

        //return $date_array = explode('-', $date);
    }

    public static function dateConvert3($date) {
        //echo $date; exit;
        if ($date != '') {
            $date_array = explode('-', $date);
            if (strlen($date_array[2]) < 4) {
                if($date_array[2]<30)
                    return $date2 =  '20' . $date_array[2] . '-' . $date_array[0] . '-' . $date_array[1];
                else
                    return $date2 =  '19' . $date_array[2] . '-' . $date_array[0] . '-' . $date_array[1];
            } else {
                return $date_array[2] . '-' . $date_array[0] . '-' . $date_array[1];
            }
        } else {
            return '';
        }
    }

    public static function dateConverttoPreviousMonth($date)
    {
        if ($date != '') {
            $date_array = explode('-', $date);
            $date2 =  $date_array[0] . '-' . ($date_array[1]-1) . '-' . '25';

            $date3 = \DateTime::createFromFormat('Y-m-d', $date2);
            return $date3->format('Y-m-d');
        }else{
            return '';
        }
    }


    public static function dateConvertEntryExit($date) {

        if ($date != '') {
            return date('Y-m-d', strtotime($date));
        } else {
            return '';
        }
    }

    public static function getDuration($time_from, $time_to) {
        $tResult = round(abs(strtotime($time_to) - strtotime($time_from)));
        return gmdate("G:i", $tResult);
    }

    public static function generateRandomString($length) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    
    public static function addNotification($title, $description, $employee_id)
    {
        $notification = new \App\Notification();
        $notification->title = $title;
        $notification->description = $description;
        $notification->employee_id = $employee_id;
        $notification->viewed = 'false';
        $notification->created_date = date('Y-m-d');
        $notification->display_date = date('Y-m-d');
        $notification->save();
        return 'Notification saved successfully';

    }

    public static function addMessage($title, $description, $employee_id, $message_to, $message_from)
    {
        $message = new \App\Message();
        $message->title = $title;
        $message->description = $description;
        $message->employee_id = $employee_id;
        $message->message_to = $message_to;
        $message->message_from = $message_from;
        $message->viewed = 'false';
        $message->created_date = date('Y-m-d');
        $message->display_date =date('Y-m-d');
        $message->save();
        return 'Message saved successfully';

    }

}
