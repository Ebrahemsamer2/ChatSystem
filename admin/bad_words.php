<?php $page_title = "Bad Words Filter";
include_once "../includes/init.php";
User::AdminOrFail();

$filter->saveBadWords();

$bad_words = $filter->getBadWords();
$bad_words_imploded = implode(",", $bad_words);

Session::set('old_bad_words', $bad_words_imploded);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <?php include "dist/includes/main_head.php"; ?>
    <link href="/assets/node_modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.css" rel="stylesheet" />
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body class="skin-blue fixed-layout">
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <?php include "dist/includes/preloader.php"; ?>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <?php include "dist/includes/header.php"; ?>
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        
        <?php include "dist/includes/sidebar.php"; ?>

        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-5 align-self-center">
                        <h4 class="text-themecolor">Bad Words</h4>
                    </div>
                    <div class="col-md-7 align-self-center text-right">
                        <div class="d-flex justify-content-end align-items-center">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="/admin/">Home</a></li>
                                <li class="breadcrumb-item active">Bad Words</li>
                            </ol>

                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">

                        <div id="js-alerts">
                            
                        </div>

                        <div class="card m-b-20">
                            <div class="card-body">

                                <div class="tags-default">
                                    <input id='bad_words' type="text" value="<?php echo $bad_words_imploded; ?>" data-role="tagsinput" placeholder="add tags" style="display: none;">

                                    <input id='old_bad_words' type="hidden" name='old_bad_words' value="<?php echo $bad_words_imploded; ?>">
                                </div>

                            </div>

                        </div>

                        <div class="card m-b-0">
                            <div class="card-body">

                                <a href="#" class='btn btn-success save-bad-words'><i class="fa fa-check"> Save</i></a>

                            </div>

                        </div>


                        

                    </div>
                </div>

                <!-- .right-sidebar -->
                <?php include "dist/includes/right_sidebar.php"; ?>
                <!-- ============================================================== -->
                <!-- End Right sidebar -->
                <!-- ============================================================== -->
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->

        <?php include "dist/includes/footer.php"; ?>

    </div>

    <?php include "dist/includes/js.php"; ?>
    <script src="/assets/node_modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
    <script src="dist/js/script.js"></script>
</body>

</html>