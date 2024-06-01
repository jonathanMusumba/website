document.addEventListener("DOMContentLoaded", function() {
    const levelSelect = document.getElementById("Level");
    const courseSelect = document.getElementById("Course");

    levelSelect.addEventListener("change", function() {
        const selectedLevel = levelSelect.value;
        courseSelect.innerHTML = ""; // Clear previous options

        if (selectedLevel === "Certificate") {
            populateCertificateCourses();
        } else if (selectedLevel === "Diploma") {
            populateDiplomaCourses();
        }
    });

    function populateCertificateCourses() {
        const certificateCourses = [
            "Certificate in Medical Laboratory Techniques",
            "Certificate in Pharmacy",
            "Certificate in Nursing",
            "Certificate in Midwifery",
            "Certificate In Baking",
            "Certificate In Cookery",
            "Certificate In Juice Processing",
            "Certificate in Records and Information Management",
            "National Certificate in Finance and Accounting",
            "National Certificate in Public Administration and Management",
            "National Certificate in Hotel and Institutional Catering"
        ];

        certificateCourses.forEach(function(Course) {
            const option = document.createElement("option");
            option.value = Course;
            option.textContent = Course;
            courseSelect.appendChild(option);
        });
    }

    function populateDiplomaCourses() {
        const diplomaCourses = [
            "Diploma In Clinical Medicine and Community Health",
            "Diploma in Nursing (Extension)",
            "Diploma in Midwifery (Extension)",
            "Diploma in Pharmacy",
            "Diploma in Medical Laboratory Techniques",
            "Diploma in Hotel and Institutional Catering",
            "Diploma in Records and Information Management"
        ];

        diplomaCourses.forEach(function(Course) {
            const option = document.createElement("option");
            option.value = course;
            option.textContent = Course;
            courseSelect.appendChild(option);
        });
    }
});