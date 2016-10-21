<?php
function the_author_full_name() {
    echo get_the_author_meta('first_name') . ' ' . get_the_author_meta('last_name');
}
