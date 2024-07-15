/**
 * ---------------
 * Task Class
 * ---------------
 *
 * Contains all functions and
 * logic for user-controlled actions
 *
 * @author creator-solutions/owen
 */
class TaskHandler {
    static onEdit(taskId) {
        alert("Edit task ID: " + taskId);
        // Implement edit functionality, e.g., redirect to edit route
        // window.location.href = `/tasks/${taskId}/edit`;
    }

    static onDelete(taskId) {
        $.ajax({
            url: `/task/delete/${taskId}`,
            type: "POST",
            contentType: "application/json",
            data: JSON.stringify({
                tasktitle: taskTitle,
                taskdescription: taskDescription,
                taskcompleted: taskCompleted,
            }),
        });
    }

    static onCreateTask(event) {
        event.preventDefault();

        const taskTitle = document.getElementById("tasktitle").value;
        const taskDescription =
            document.getElementById("taskdescription").value;
        const taskCompleted = document.getElementById("taskcompleted").checked;

        $.ajax({
            url: "/tasks/store",
            type: "POST",
            contentType: "application/json",
            data: JSON.stringify({
                tasktitle: taskTitle,
                taskdescription: taskDescription,
                taskcompleted: taskCompleted,
            }),
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
                //Reference Class as 'this' is not preserved in the success callback
                TaskHandler.hideOverlayAndPopup();
                alert("Task created successfully");
                window.location.reload();
            },
            error: function (xhr, status, error) {
                alert("Failed to create task: ", error);
            },
        });
    }

    static onShowPopUp() {
        this.showOverlayAndPopUp();
    }

    static hideOverlayAndPopup() {
        const overlay = document.getElementById("overlay");
        overlay.classList.add("hidden");

        const popup = document.getElementById("popup");
        popup.classList.add("hidden");
    }

    static showOverlayAndPopUp() {
        const overlay = document.getElementById("overlay");
        overlay.classList.remove("hidden");

        const popup = document.getElementById("popup");
        popup.classList.remove("hidden");
    }
}
