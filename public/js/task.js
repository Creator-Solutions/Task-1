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
    /**
     * Opens the popup form and populates
     * the form fields with the data from
     * the database
     * @param {*} taskId
     */
    static onEdit(taskId) {
        $.ajax({
            url: `/tasks/${taskId}`,
            method: "GET",
            contentType: "application/json",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
                /**
                 * Display task information in the popup fields
                 */
                document.getElementById("tasktitle").value =
                    response.task.task_title;
                document.getElementById("taskdescription").value =
                    response.task.task_description;
                document.getElementById("taskcompleted").checked =
                    response.task.task_completed === "0" ? false : true;

                //Hide the defualt submit button
                document.getElementById("btn-submit").classList.add("hidden");

                /**
                 * Display the secondary submit button add assign onClick
                 */
                document
                    .getElementById("btn-submitEdit")
                    .classList.remove("hidden");

                document
                    .getElementById("btn-submitEdit")
                    .addEventListener("click", function () {
                        TaskHandler.onSubmitEdit(taskId);
                    });
            },
            error: function (xhr, status, error) {
                alert("Failed to delete task: ", error);
                console.error("Error:", error);
                console.error("Status:", status);
                console.error("Response:", xhr.responseText);
            },
        });
        this.showOverlayAndPopUp();
    }

    /**
     * Secondary method to update the task based on ID
     * Showed dynamically if a task is found
     *
     * @param {*} id
     */
    static onSubmitEdit(id) {
        const taskTitle = document.getElementById("tasktitle").value;
        const taskDescription =
            document.getElementById("taskdescription").value;
        const taskCompleted = document.getElementById("taskcompleted").checked;

        $.ajax({
            url: `/tasks/${id}`,
            type: "PUT",
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
                alert("Task updated successfully");
                window.location.reload();
            },
            error: function (xhr, status, error) {
                alert("Failed to update task: ", error);
            },
        });
    }

    /**
     * Method to delete a task based on ID
     * uses Ajax call to delete a task entry
     *
     * @param {*} taskId
     */
    static onDelete(taskId) {
        $.ajax({
            url: `/tasks/${taskId}`,
            method: "DELETE",
            contentType: "application/json",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
                //Reference Class as 'this' is not preserved in the success callback
                alert("Task Deleted successfully");
                window.location.reload();
            },
            error: function (xhr, status, error) {
                alert("Failed to delete task: ", error);
                console.error("Error:", error);
                console.error("Status:", status);
                console.error("Response:", xhr.responseText);
            },
        });
    }

    /**
     * Method to create a new task
     *
     * - Retrieve the form input data
     * -
     * @param {*} event
     */
    static onCreateTask(event) {
        event.preventDefault(); // prevent page reloads

        // Retrieve the form values
        const taskTitle = document.getElementById("tasktitle").value;
        const taskDescription =
            document.getElementById("taskdescription").value;
        const taskCompleted = document.getElementById("taskcompleted").checked;

        /**
         * Ajax call to create a new task entry
         */
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

    /**
     * Static method to hide the overlay and popup form
     */
    static hideOverlayAndPopup() {
        const overlay = document.getElementById("overlay");
        overlay.classList.add("hidden");

        const popup = document.getElementById("popup");
        popup.classList.add("hidden");
    }

    /**
     * Static method to show the overlay and popup form
     */
    static showOverlayAndPopUp() {
        const overlay = document.getElementById("overlay");
        overlay.classList.remove("hidden");

        const popup = document.getElementById("popup");
        popup.classList.remove("hidden");
    }
}
