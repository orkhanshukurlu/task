<?php

if (! function_exists('base_url'))
{
    function base_url()
    {
        return 'http://localhost/task';
    }
}

if (! function_exists('show_error'))
{
    function show_error($field)
    {
        if (Flash::has($field)) {
            return '<small style="color: red">' . Flash::get($field) . '</small>';
        }
    }
}



if (! function_exists('alert')) {
    function alert()
    {
        return "<script>
                iziToast.show({
                    title: 'Hey',
                    message: 'What would you like to add?',
                    position: 'topRight'
                });
            </script>";
    }
}