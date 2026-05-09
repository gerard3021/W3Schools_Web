<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>W3Schools DB Manager</title>
    <style>
* { box-sizing: border-box; margin: 0; padding: 0; }
body { font-family: Arial, sans-serif; font-size: 14px; background: #f0f2f5; color: #222; }
nav { background: #04AA6D; padding: 10px 20px; display: flex; gap: 6px; flex-wrap: wrap; align-items: center; }
nav .brand { color: white; font-weight: bold; font-size: 16px; margin-right: 16px; }
nav a { color: white; text-decoration: none; font-size: 13px; padding: 5px 10px; border-radius: 4px; }
nav a:hover { background: rgba(255,255,255,0.2); }
main { padding: 24px; max-width: 1100px; margin: 24px auto; background: white; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.10); }
h1 { font-size: 22px; margin-bottom: 18px; color: #04AA6D; border-bottom: 2px solid #04AA6D; padding-bottom: 8px; }
.campo { margin-bottom: 12px; display: flex; align-items: flex-start; gap: 8px; }
label { display: inline-block; min-width: 160px; font-weight: bold; padding-top: 6px; }
input[type=text], input[type=number], input[type=date], textarea, select { flex: 1; max-width: 400px; padding: 6px 9px; border: 1px solid #ccc; border-radius: 4px; font-size: 14px; }
textarea { resize: vertical; min-height: 70px; }
table { border-collapse: collapse; width: 100%; margin-top: 10px; font-size: 13px; }
th, td { border: 1px solid #ddd; padding: 7px 10px; text-align: left; }
th { background: #04AA6D; color: white; }
tr:nth-child(even) { background: #f9f9f9; }
tr:hover { background: #e8f5ee; }
.alerta { background: #d4edda; border: 1px solid #28a745; color: #155724; padding: 10px 16px; border-radius: 4px; margin-bottom: 16px; }
.error-lista { background: #f8d7da; border: 1px solid #dc3545; color: #721c24; padding: 10px 16px; border-radius: 4px; margin-bottom: 16px; }
.error-lista div { margin-bottom: 4px; }
.btn { display: inline-block; padding: 6px 14px; border-radius: 4px; text-decoration: none; font-size: 13px; cursor: pointer; border: none; }
.btn-green { background: #04AA6D; color: white; } .btn-green:hover { background: #028a57; }
.btn-blue  { background: #2196F3; color: white; } .btn-blue:hover  { background: #1565c0; }
.btn-red   { background: #e53935; color: white; } .btn-red:hover   { background: #b71c1c; }
.btn-gray  { background: #888;    color: white; } .btn-gray:hover  { background: #555; }
.btn-sm { padding: 4px 9px; font-size: 12px; }
.top-bar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; }
input[type=submit] { padding: 7px 20px; background: #04AA6D; color: white; border: none; border-radius: 4px; font-size: 14px; cursor: pointer; }
input[type=submit]:hover { background: #028a57; }
    </style>
</head>
<body>
<nav>
    <span class="brand">W3Schools DB</span>
    <a href="<?= base_url('categories') ?>">Categorías</a>
    <a href="<?= base_url('suppliers') ?>">Proveedores</a>
    <a href="<?= base_url('customers') ?>">Clientes</a>
    <a href="<?= base_url('employees') ?>">Empleados</a>
    <a href="<?= base_url('shippers') ?>">Envíos</a>
    <a href="<?= base_url('products') ?>">Productos</a>
    <a href="<?= base_url('orders') ?>">Órdenes</a>
</nav>
<main>
