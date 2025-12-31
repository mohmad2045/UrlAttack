<?php
session_start();

function checkUserPermission($requiredType) {
    if (!isset($_SESSION['user_id'])) {
        return false;
    }
    
    $userType = $_SESSION['user_type'] ?? 'user';
    
    if ($requiredType === 'admin' && $userType !== 'admin') {
        return false;
    }
    
    return true;
}

function getReport($type) {
    if (!checkUserPermission($type)) {
        header('HTTP/1.1 403 Forbidden');
        echo "Access Denied: You don't have permission to view this report";
        exit();
    }
    
    if ($type === 'admin') {
        return fetchAdminReport();
    } elseif ($type === 'user') {
        return fetchUserReport();
    } else {
        return "Invalid report type";
    }
}

if (isset($_GET['type'])) {
    $reportType = $_GET['type'];
    $report = getReport($reportType);
    echo $report;
} else {
    echo "Please specify a report type";
}

function fetchAdminReport() {
    return "Admin Report Content (Sensitive Data)";
}

function fetchUserReport() {
    return "User Report Content (General Data)";
}
?>