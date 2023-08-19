<?php
require_once '../../session/sessionStart.php';
?>
<aside class="main-sidebar sidebar-dark-primary bg-black elevation-4">
    <a href="./" class="brand-link logo-switch bg-black">
        <h4 class="brand-image-xl logo-xl mb-0 text-center">Kokoro <b>Mart</b></h4>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="user-panel mt-3 mb-3 text-center">
            <div class="mb-3">
                <?= $usernameSession;?>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item" id="dashboard">
                    <a href="/JapaneseOnlineTicketingSystem/AdminSide/Dashboard/dashboard.php" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>

                <!-- Roles -->
                <li class="nav-item" id="roles">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa fa-id-card"></i>
                        <p>
                            Roles
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item pl-1">
                            <a href="/JapaneseOnlineTicketingSystem/AdminSide/Role/view_all_roles.php" class="nav-link" id="view_roles">
                                <i class="far fa-circle nav-icon"></i>
                                <p>View Roles</p>
                            </a>
                        </li>
                        <li class="nav-item pl-1">
                            <a href="/JapaneseOnlineTicketingSystem/AdminSide/Role/add_role.php" class="nav-link" id="add_roles">
                                <i class="fa fa-circle-plus nav-icon"></i>
                                <p>Add Role</p>
                            </a>
                        </li>

                    </ul>
                </li>

                <!-- Status -->
                <li class="nav-item" id="status">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa fa-ellipsis-h"></i>
                        <p>
                            Status
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item pl-1">
                            <a href="/JapaneseOnlineTicketingSystem/AdminSide/Status/view_all_status.php" class="nav-link" id="view_status">
                                <i class="far fa-circle nav-icon"></i>
                                <p>View Status</p>
                            </a>
                        </li>
                        <li class="nav-item pl-1">
                            <a href="/JapaneseOnlineTicketingSystem/AdminSide/Status/add_status.php" class="nav-link" id="add_status">
                                <i class="fa fa-circle-plus nav-icon"></i>
                                <p>Add Status</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Category -->
                <li class="nav-item" id="categories">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa fa-layer-group"></i>
                        <p>
                            Category
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item pl-1">
                            <a href="/JapaneseOnlineTicketingSystem/AdminSide/Category/view_all_categories.php" class="nav-link" id="view_all_categories">
                                <i class="far fa-circle nav-icon"></i>
                                <p>View Category</p>
                            </a>
                        </li>
                        <li class="nav-item pl-1">
                            <a href="/JapaneseOnlineTicketingSystem/AdminSide/Category/add_category.php" class="nav-link" id="add_category">
                                <i class="fa fa-plus-circle nav-icon"></i>
                                <p>Add Category</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Users -->
                <li class="nav-item" id="users">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa fa-users"></i>
                        <p>
                            Users
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item pl-1">
                            <a href="/JapaneseOnlineTicketingSystem/AdminSide/Users/view_all_users.php" class="nav-link" id="view_users">
                                <i class="far fa-circle nav-icon"></i>
                                <p>View Users</p>
                            </a>
                        </li>
                        <li class="nav-item pl-1">
                            <a href="/JapaneseOnlineTicketingSystem/AdminSide/Users/add_user.php" class="nav-link" id="add_users">
                                <i class="fa fa-plus-circle nav-icon"></i>
                                <p>Add User</p>
                            </a>
                        </li>

                    </ul>
                </li>

                <!-- Events -->
                <li class="nav-item" id="events">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa fa-calendar"></i>
                        <p>
                            Event
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item pl-1">
                            <a href="/JapaneseOnlineTicketingSystem/AdminSide/Event/view_all_events.php" class="nav-link" id="view_events">
                                <i class="far fa-circle nav-icon"></i>
                                <p>View Events</p>
                            </a>
                        </li>
                        <li class="nav-item pl-1">
                            <a href="/JapaneseOnlineTicketingSystem/AdminSide/Event/add_event.php" class="nav-link" id="add_event">
                                <i class="fa fa-plus-circle nav-icon"></i>
                                <p>Add Event</p>
                            </a>
                        </li>

                    </ul>
                </li>

                <!-- Card -->
                <li class="nav-item" id="cards">
                    <a href="/JapaneseOnlineTicketingSystem/AdminSide/Card/view_all_card.php" class="nav-link">
                        <i class="nav-icon fa fa-credit-card"></i>
                        <p>
                            Card
                            <!--<i class="fas fa-angle-left right"></i>-->
                        </p>
                    </a>
                    <!--                    <ul class="nav nav-treeview">
                                            <li class="nav-item pl-2">
                                                <a href="/JapaneseOnlineTicketingSystem/AdminSide/Card/view_all_card.php" class="nav-link" id="view_all_card">
                                                    <i class="far fa-eye nav-icon"></i>
                                                    <p>View Card</p>
                                                </a>
                                            </li>
                                        </ul>-->
                </li>

                <!-- Ticket -->
                <li class="nav-item" id="tickets">
                    <a href="/JapaneseOnlineTicketingSystem/AdminSide/Ticket/view_all_ticket.php" class="nav-link">
                        <i class="nav-icon fa fa-ticket-alt"></i>
                        <p>
                            Ticket
                            <!--<i class="fas fa-angle-left right"></i>-->
                        </p>
                    </a>
                    <!--                    <ul class="nav nav-treeview">
                                            <li class="nav-item pl-2">
                                                <a href="/JapaneseOnlineTicketingSystem/AdminSide/Ticket/view_all_ticket.php" class="nav-link" id="view_all_ticket">
                                                    <i class="far fa-eye nav-icon"></i>
                                                    <p>View Ticket</p>
                                                </a>
                                            </li>
                                        </ul>-->
                </li>

                <!-- Orders -->
                <li class="nav-item" id="orders">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa fa-shopping-bag"></i>
                        <p>
                            Order
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item pl-1">
                            <a href="/JapaneseOnlineTicketingSystem/AdminSide/Order/view_all_orders.php" class="nav-link" id="view_all_order">
                                <i class="far fa-circle nav-icon"></i>
                                <p>View Order</p>
                            </a>
                        </li>
                        <li class="nav-item pl-1">
                            <a href="/JapaneseOnlineTicketingSystem/AdminSide/Order/view_order_details.php" class="nav-link" id="view_order_details">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Order details</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Payment -->
                <li class="nav-item" id="payment">
                    <a href="/JapaneseOnlineTicketingSystem/AdminSide/Payment/view_all_payments.php" class="nav-link">
                        <i class="nav-icon fa fa-receipt"></i>
                        <p>
                            Payment
                            <!--<i class="fas fa-angle-left right"></i>-->
                        </p>
                    </a>
                    <!--                    <ul class="nav nav-treeview">
                                            <li class="nav-item pl-2">
                                                <a href="/JapaneseOnlineTicketingSystem/AdminSide/Payment/view_all_payments.php" class="nav-link" id="view_payment">
                                                    <i class="far fa-eye nav-icon"></i>
                                                    <p>View Payment</p>
                                                </a>
                                            </li>
                                        </ul>-->
                </li>
                
                <!-- Payment -->
                <li class="nav-item" id="report">
                    <a href="/JapaneseOnlineTicketingSystem/AdminSide/Report/report.php" class="nav-link">
                        <i class="nav-icon fa fa-file"></i>
                        <p>
                           Report
                            <!--<i class="fas fa-angle-left right"></i>-->
                        </p>
                    </a>
                    <!--                    <ul class="nav nav-treeview">
                                            <li class="nav-item pl-2">
                                                <a href="/JapaneseOnlineTicketingSystem/AdminSide/Payment/view_all_payments.php" class="nav-link" id="view_payment">
                                                    <i class="far fa-eye nav-icon"></i>
                                                    <p>View Payment</p>
                                                </a>
                                            </li>
                                        </ul>-->
                </li>


                <li class="nav-item">
                    <a href="../../session/sessionEnd.php" class="nav-link">
                        <i class="nav-icon fa fa-sign-out-alt"></i>
                        <p>
                            Logout
                        </p>
                    </a>
                </li>

            </ul>
        </nav>
        <!-- Sidebar Menu -->
    </div>
    <!-- Sidebar -->
</aside>