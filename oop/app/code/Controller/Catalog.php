<?php

namespace Controller;

class Catalog
{
    public function show($id = null)
    {
        if ($id !== null) {
            echo 'Catalog controller ID ' . $id;
        } else {
            echo '404 no id';
        }

        if ($id === 'you-got-clickbaited') {
            echo '<div class="clickb" style="text-align:center">';
            echo '<b style="font-size:68px;"=>YOU GOT CLICKBAITED!</b>';
            echo '</div>';
            die();
        }
    }

    public function all($id = null)
    {
        for ($i = 0; $i < 10; $i++) {
            echo '<a href="http://localhost/pamokos/oop/index.php/catalog/show/' . $i . '">Read more</a>';
            echo '<br>';
        }

        if ($id === 'you-got-clickbaited') {
            echo '<div class="clickb" style="text-align:center">';
            echo '<b style="font-size:68px;"=>YOU GOT CLICKBAITED!</b>';
            echo '</div>';
            die();
        }
    }

    public function create($data)
    {

    }

    public function update($data)
    {
        echo 'I\'m Robot';
    }
}