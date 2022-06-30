<?php

function draw_alert_helper($style, $title, $description)
{
    echo <<<GFG
        <div class="alert alert-$style alert-dismissible fade show" role="alert">
            <div class="alert-message">
                <strong>$title</strong> $description
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    GFG;
}
