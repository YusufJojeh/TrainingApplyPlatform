<?php
/**
 * Aurora Table Component
 * 
 * Usage:
 * renderTable([
 *     'headers' => ['Student', 'Major', 'Date Applied', 'Status', 'Actions'],
 *     'rows' => $data,
 *     'actions' => ['view', 'accept', 'reject'],
 *     'statusField' => 'status'
 * ]);
 */

function renderTable($config) {
    $headers = $config['headers'] ?? [];
    $rows = $config['rows'] ?? [];
    $actions = $config['actions'] ?? [];
    $statusField = $config['statusField'] ?? null;
    $tableId = $config['tableId'] ?? 'aurora-table';
    $responsive = $config['responsive'] ?? true;
    
    // Start table wrapper
    if ($responsive) {
        echo '<div class="table-responsive">';
    }
    
    echo '<table class="aurora" id="' . htmlspecialchars($tableId) . '">';
    
    // Headers
    if (!empty($headers)) {
        echo '<thead><tr>';
        foreach ($headers as $header) {
            echo '<th>' . htmlspecialchars($header) . '</th>';
        }
        echo '</tr></thead>';
    }
    
    // Body
    echo '<tbody>';
    foreach ($rows as $row) {
        echo '<tr>';
        
        foreach ($row as $key => $value) {
            // Skip action and status fields as they're handled separately
            if ($key === 'actions' || $key === $statusField) {
                continue;
            }
            
            // Handle special field types
            if ($key === 'student_avatar' || $key === 'profile_avatar') {
                echo '<td><div class="aurora-avatar">';
                if (isset($value['image'])) {
                    echo '<img src="' . htmlspecialchars($value['image']) . '" alt="Avatar" class="aurora-avatar-img">';
                } else {
                    echo '<i class="bi bi-person-circle aurora-avatar-icon"></i>';
                }
                echo '</div></td>';
            } elseif ($key === 'date' || $key === 'created_at') {
                echo '<td>' . date('M d, Y', strtotime($value)) . '</td>';
            } elseif ($key === 'datetime' || $key === 'updated_at') {
                echo '<td>' . date('M d, Y H:i', strtotime($value)) . '</td>';
            } else {
                echo '<td>' . htmlspecialchars($value) . '</td>';
            }
        }
        
        // Status field
        if ($statusField && isset($row[$statusField])) {
            $status = $row[$statusField];
            $statusClass = match($status) {
                'accepted', 'success', 'read' => 'accepted-pill',
                'rejected', 'danger' => 'rejected-pill',
                default => 'pending-pill'
            };
            $statusText = ucfirst($status);
            echo '<td><span class="pill ' . $statusClass . '">' . $statusText . '</span></td>';
        }
        
        // Actions
        if (!empty($actions)) {
            echo '<td><div class="aurora-actions">';
            
            foreach ($actions as $action) {
                $actionConfig = is_array($action) ? $action : ['type' => $action];
                $type = $actionConfig['type'];
                $url = $actionConfig['url'] ?? '#';
                $title = $actionConfig['title'] ?? ucfirst($type);
                $icon = $actionConfig['icon'] ?? getActionIcon($type);
                $class = $actionConfig['class'] ?? getActionClass($type);
                $onclick = $actionConfig['onclick'] ?? '';
                
                echo '<button class="action-btn ' . $class . '" title="' . htmlspecialchars($title) . '"';
                if ($onclick) {
                    echo ' onclick="' . htmlspecialchars($onclick) . '"';
                }
                echo '>';
                echo '<i class="' . $icon . '"></i>';
                echo '</button>';
            }
            
            echo '</div></td>';
        }
        
        echo '</tr>';
    }
    echo '</tbody>';
    echo '</table>';
    
    if ($responsive) {
        echo '</div>';
    }
}

function getActionIcon($type) {
    return match($type) {
        'view' => 'bi bi-eye',
        'edit' => 'bi bi-pencil',
        'delete' => 'bi bi-trash',
        'accept' => 'bi bi-check-lg',
        'reject' => 'bi bi-x-lg',
        'message' => 'bi bi-envelope',
        'reply' => 'bi bi-reply',
        'mark-read' => 'bi bi-check',
        default => 'bi bi-gear'
    };
}

function getActionClass($type) {
    return match($type) {
        'view' => 'view-btn',
        'edit' => 'edit-btn',
        'delete' => 'delete-btn',
        'accept' => 'accept-btn',
        'reject' => 'reject-btn',
        'message' => 'message-btn',
        'reply' => 'reply-btn',
        'mark-read' => 'mark-read-btn',
        default => 'default-btn'
    };
}
?> 