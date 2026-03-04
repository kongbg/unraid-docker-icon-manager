// Docker Icon Manager Script

// 上传图标
document.addEventListener('DOMContentLoaded', function() {
    const uploadForm = document.getElementById('upload-form');
    const uploadMessage = document.getElementById('upload-message');

    if (uploadForm) {
        uploadForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(uploadForm);
            
            fetch('/plugins/docker-icon-manager/upload.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    uploadMessage.className = 'success';
                    uploadMessage.textContent = data.message;
                    // 刷新页面
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                } else {
                    uploadMessage.className = 'error';
                    uploadMessage.textContent = data.message;
                }
            })
            .catch(error => {
                uploadMessage.className = 'error';
                uploadMessage.textContent = 'An error occurred: ' + error.message;
            });
        });
    }
});

// 删除图标
function deleteIcon(containerName) {
    if (confirm('Are you sure you want to delete the icon for container ' + containerName + '?')) {
        fetch('/plugins/docker-icon-manager/delete.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ container: containerName })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // 刷新页面
                location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            alert('An error occurred: ' + error.message);
        });
    }
}

// 刷新容器列表
function refreshContainers() {
    fetch('/plugins/docker-icon-manager/refresh.php')
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Error refreshing containers: ' + data.message);
        }
    })
    .catch(error => {
        alert('An error occurred: ' + error.message);
    });
}
