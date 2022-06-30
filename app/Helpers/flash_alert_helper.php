<?php
function configure_flash_alert($style, $title, $description)
{
    $session = \Config\Services::session();
    $session->setFlashdata('displayAlert', true);
    $session->setFlashdata('style', $style);
    $session->setFlashdata('title', $title);
    $session->setFlashdata('description', $description);
}

function show_flash_alert()
{
    helper('alert');
    $session = \Config\Services::session();
    if ($session->getFlashdata('displayAlert')) {
        draw_alert_helper($session->getFlashdata('style'), $session->getFlashdata('title'), $session->getFlashdata('description'));
    }
}
