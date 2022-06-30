<?php

function auth_redirect()
{
    if (!session()->get('isLoggedIn')) {
        return redirect()->to('/');
    }
    return redirect()->to('/inicio');
}
