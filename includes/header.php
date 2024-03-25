<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Watashitachi Manga</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 5.3.0 -->
  <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Bootstrap Icon -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">

  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
  <!-- custom CSS -->
  <link rel="stylesheet" href="dist/css/custom.css">

  <!-- Include RateYo library -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.css">
  <!-- Google fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Thai+Looped:wght@400;500;800&family=Poppins:ital,wght@0,300;0,400;0,500;0,600;1,400&display=swap" rel="stylesheet">

  <!-- Custom CSS -->
  <style type="text/css">
    @media (min-width: 768px) {
      .search-icon {
        display: none;
      }

      #navbarSearchInput {
        width: 60px;
        display: inline-block;
      }

      #navbarSearchInput:focus {
        width: 100px;
      }
    }

    /* Styles for screens smaller than 768px */
    @media (max-width: 767px) {
      .search-icon {
        display: inline-block;
        cursor: pointer;
      }

      #navbarSearchInput {
        display: none;
      }

      .show-search-input {
        display: inline-block !important;
      }

      #searchResults {
        bottom: 100%;
        top: auto;
      }
    }

    /* Medium devices (desktops, 992px and up) */
    @media (min-width: 992px) {
      #navbarSearchInput {
        width: 150px;
      }

      #navbarSearchInput:focus {
        width: 250px;
      }
    }




    .word-wrap {
      overflow-wrap: break-word;
    }

    .prod-body {
      height: 300px;
    }

    .box:hover {
      box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);
    }

    .register-box {
      margin-top: 20px;
    }

    #trending {
      list-style: none;
      padding: 10px 5px 10px 15px;
    }

    #trending li {
      padding-left: 1.3em;
    }

    #trending li:before {
      content: "\f046";
      font-family: FontAwesome;
      display: inline-block;
      margin-left: -1.3em;
      width: 1.3em;
    }

    /*Magnify*/
    .magnify>.magnify-lens {
      width: 100px;
      height: 100px;
    }
  </style>

</head>