<?php
function message_mail($data,$title)
{
    $message = $title;
    $message .= "<table>";
    foreach($_POST as $key => $value) {
        $message .= "<tr><td>". $key .":</td><td>". $value. '</td></tr>';
    }
    $message .= "</table>";
    return $message;
}
