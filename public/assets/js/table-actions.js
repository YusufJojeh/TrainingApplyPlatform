document.addEventListener('DOMContentLoaded', function() {
    // Handle action button clicks
    document.querySelectorAll('.action-btn').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            const action = this.dataset.action;
            const row = this.closest('tr');
            const rowId = row.dataset.id;
            
            if (!rowId) {
                console.warn('No row ID found for action:', action);
                return;
            }
            
            // Handle different action types
            switch(action) {
                case 'view':
                    window.location.href = `?controller=application&action=view&id=${rowId}`;
                    break;
                case 'edit':
                    window.location.href = `?controller=application&action=edit&id=${rowId}`;
                    break;
                case 'delete':
                    if (confirm('Are you sure you want to delete this item?')) {
                        window.location.href = `?controller=application&action=delete&id=${rowId}`;
                    }
                    break;
                case 'accept':
                    if (confirm('Accept this application?')) {
                        window.location.href = `?controller=application&action=update&id=${rowId}&status=accepted`;
                    }
                    break;
                case 'reject':
                    if (confirm('Reject this application?')) {
                        window.location.href = `?controller=application&action=update&id=${rowId}&status=rejected`;
                    }
                    break;
                case 'message':
                    window.location.href = `?controller=message&action=compose&id=${rowId}`;
                    break;
                case 'reply':
                    window.location.href = `?controller=message&action=reply&id=${rowId}`;
                    break;
                case 'mark-read':
                    window.location.href = `?controller=message&action=markRead&id=${rowId}`;
                    break;
                default:
                    console.warn('Unknown action:', action);
            }
        });
    });
    
    // Add hover effects for action buttons
    document.querySelectorAll('.action-btn').forEach(button => {
        button.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.1)';
            this.style.boxShadow = '0 2px 8px rgba(0,0,0,0.3)';
        });
        
        button.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1)';
            this.style.boxShadow = 'none';
        });
    });
}); 