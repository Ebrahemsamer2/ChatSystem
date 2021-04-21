<?php $page_title = "Admin Chat";
include_once "../includes/init.php";
User::AdminOrFail();

Message::sendMessage();

$prev_chats = User::get_prev_chats();
$user_id = $_SESSION['id'];

$username = $_SESSION['username'];

if(isset($_GET['cid']) && $_GET['cid'] !== '')
{
    $cid = filter_input(INPUT_GET, 'cid', FILTER_SANITIZE_STRING);
    $cid = $hashids->decode($cid)[0];
    if($user_id !== $cid)
    {
        $messages = User::get_chat($cid)[1];
        $last_chat = User::get_chat($cid)[0];
        Session::set('user_chat_id', $last_chat->id);
        
        Message::mark_as_seen($last_chat->id, $user_id);
    }
    else { Session::redirect("/?chat=1"); }

    $username_conversation = $last_chat->username;
}
else
{
    $last_chat = User::get_last_chat();
    $messages = $last_chat[1];
    $last_chat = $last_chat[0];

    if($last_chat)
    {
        Message::mark_as_seen($last_chat->id, $user_id);
        Session::set('user_chat_id', $last_chat->id);
        $username_conversation = $last_chat->username;
    }
}
if($last_chat)
{
    $last_chat_id = $last_chat->id;
    $query = "SELECT count(*) as c FROM messages WHERE ( sender_id = ? AND receiver_id = ? ) OR ( sender_id = ? AND receiver_id = ? ) ";

    $values = [$last_chat_id, $user_id, $user_id, $last_chat_id];
    $messages_count = $db->customQuery($query, $values)[0]->c;
}
else { $username_conversation = "Unavailabe User."; }  
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <?php include "dist/includes/main_head.php"; ?>

    <link href="dist/css/pages/chat-app-page.css" rel="stylesheet">
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
                        <h4 class="text-themecolor">Chat</h4>
                    </div>
                    <div class="col-md-7 align-self-center text-right">
                        <div class="d-flex justify-content-end align-items-center">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="/admin/">Home</a></li>
                                <li class="breadcrumb-item active">Chat</li>
                            </ol>

                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">

                        <div class="card m-b-0">
                            <!-- .chat-row -->
                            <div class="chat-main-box">
                                <!-- .chat-left-panel -->
                                <div class="chat-left-aside">
                                    <div class="open-panel"><i class="ti-angle-right"></i></div>
                                    <div class="chat-left-inner" style="height: 135px;">
                                        <div class="form-material">
                                            <input class="form-control p-2" type="text" placeholder="Search Contact">
                                        </div>
                                        <ul id='contact-list' class="chatonline style-none ps ps--theme_default ps--active-y" data-ps-id="b6819ddf-49cf-6914-f08d-4c30392cbe5c">

                                        <?php foreach($prev_chats as $prev_chat):
                                        $hash = $hashids->encode($prev_chat->id);
                                        ?>
                                            <li id='chat_<?php echo $hash; ?>' class="<?php echo $prev_chat->id == $last_chat->id ? 'active' : ''; ?>">

                                                <a href="/admin/chat.php?cid=<?php echo $hash; ?>"><img width="30" height="30" src="/user_images/<?php echo $prev_chat->image; ?>" alt="user-img" class="img-circle user_img">
                                                    <span><?php echo $prev_chat->username; ?> <small class="text-success">online</small>

                                                </span></a>
                                            </li>

                                            <?php endforeach; ?>
                                            <li class="p-20"></li>
                                        <div class="ps__scrollbar-x-rail" style="left: 0px; bottom: 0px;"><div class="ps__scrollbar-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps__scrollbar-y-rail" style="top: 0px; right: 0px; height: 386px;"><div class="ps__scrollbar-y" tabindex="0" style="top: 0px; height: 229px;"></div></div>
                                    
                                    </ul>
                                    </div>
                                </div>

                                <div class="chat-right-aside">

                                    <div class="chat-main-header">
                                        <div class="p-3 b-b">
                                            <h4 class="box-title">Chat Message</h4>
                                        </div>
                                    </div>

                                    <div id='messages-container' class="chat-rbox ps ps--theme_default ps--active-y" data-ps-id="65964516-486e-b2e2-0546-35968e8e5caa">
                                        
                                        <ul id='<?php echo $user_id; ?>' class="chat-list p-3" style="height: 250px;">
                                        
                                            <?php foreach($messages as $key => $message):
                                                $sending_class = $message->sender_id !== $user_id ? '' : 'reverse';
                                            ?>

                                            <!--chat Row -->
                                            <li class="<?php echo $sending_class; ?>">
                                                <?php if($sending_class !== 'reverse'): ?>
                                                    
                                                    <div class="chat-img"><img src="../assets/images/users/5.jpg" alt="user"></div>

                                                <?php endif; ?>
                                                <div class="chat-content">
                                                    <h5>
                                                        <?php echo $sending_class !== 'reverse' ? $username_conversation : $username; ?>
                                                    </h5>
                                                    <div class="box bg-light-inverse">
                                                        <?php echo $message->message; ?>
                                                    </div>
                                                    <div class="chat-time">
                                                    <?php
                                                        $time = $message->datetime;
                                                        echo date("m-d H:i");
                                                    ?>
                                                    </div>
                                                </div>

                                                <?php if($sending_class === 'reverse'): ?>
                                                    
                                                    <div class="chat-img"><img src="../assets/images/users/5.jpg" alt="user"></div>

                                                <?php endif; ?>
                                            </li>

                                            <?php endforeach; ?>

                                        </ul>

                                    <div class="ps__scrollbar-x-rail" style="left: 0px; bottom: 0px;"><div class="ps__scrollbar-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps__scrollbar-y-rail" style="top: 0px; right: 0px; height: 206px;"><div class="ps__scrollbar-y" tabindex="0" style="top: 0px; height: 62px;"></div></div></div>
                                    <?php if($last_chat): ?>
                                    <div class="card-body border-top">
                                        <div class="row">
                                            <div class="col-8">
                                                <textarea id='message-content' placeholder="Type your message here" class="form-control border-0"></textarea>
                                            </div>
                                            <div class="col-4 text-right">
                                                <button type="button" class="btn btn-info btn-circle btn-lg send_btn"><i class="fa fa-paper-plane-o"></i> </button>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                </div>
                                <!-- .chat-right-panel -->
                            </div>
                            <!-- /.chat-row -->
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
    <script src="dist/js/pages/chat.js"></script>
    <script src="dist/js/script.js"></script>
</body>

</html>