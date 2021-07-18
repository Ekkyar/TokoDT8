<?php

function output_json($data)
{
    $ci = get_instance();
    $data = json_encode($data);
    $ci->output->set_content_type('application/json')->set_output($data);
}

function set_pesan($pesan, $tipe = true)
{
    $ci = get_instance();
    if ($tipe) {
        $ci->session->set_flashdata('pesan', "<div class='alert alert-success'>{$pesan}<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
    } else {
        $ci->session->set_flashdata('pesan', "<div class='alert alert-danger'>{$pesan}<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
    }
}

// helper reff from Material
function open_dropdown($view = [], $classname)
{
    $ci = get_instance();
    $page = $ci->uri->segment(1);
    if (in_array($page, $view)) {
        return $classname;
    }
}

function total_harga($idTransaksi)
{
    $ci = get_instance();

    return 1;
    // Query total harga
}

function format_uang($number = 0, $acc = true)
{
    if ($acc) $acc = "Rp. ";
    return $acc . number_format($number, 0, ',', '.');
}

function generate_id($char = "", $table = "", $field = "", $date = "", $digit = 5)
{
    $ci = get_instance();

    $prefix = $char . $date;
    $lastId = $ci->Toko_Model->generateId($prefix, $table, $field);
    $noUrut = (int) substr($lastId, -$digit, $digit);
    $noUrut += 1;

    $newId = $char . $date . sprintf("%0{$digit}s", $noUrut);
    return $newId;
}
