<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ $title ?? 'Dashboard' }} - Inventory Management System</title>
        <link href="/css/styles.css" rel="stylesheet" />
        <link rel="icon" type="image/x-icon" href="/assets/img/favicon.png" />
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />

        <link href="https://cdnjs.cloudflare.com/ajax/libs/devexpress-diagram/2.2.2/dx-diagram.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/devexpress-gantt/4.1.49/dx-gantt.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme-dist/23.1.6/css/dx.light.compact.css" rel="stylesheet">

        <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.28.0/feather.min.js" crossorigin="anonymous"></script>
    </head>
