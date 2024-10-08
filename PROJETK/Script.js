// Modal functionality
var modal = document.getElementById("login-modal");
var registerModal = document.getElementById("registerModal");
var btn = document.getElementById("login-btn");
var spans = document.getElementsByClassName("close");
var registerLink = document.getElementById("registerLink");
var loginLink = document.getElementById("loginLink");
var absenceModal = document.getElementById('absence-modal');
var addAbsenceBtn = document.getElementById('add-absence');
var saveAbsenceBtn = document.getElementById('save-absence');

btn.onclick = function() {
    modal.style.display = "block"; 
}

registerLink.onclick = function() {
    modal.style.display = "none";  
    registerModal.style.display = "block"; 
}

loginLink.onclick = function() {
    registerModal.style.display = "none";  
    modal.style.display = "block";  
}

for (let i = 0; i < spans.length; i++) {
    spans[i].onclick = function() {
        modal.style.display = "none";  
        registerModal.style.display = "none";
        absenceModal.style.display = 'none'; 
    }
}

window.onclick = function(event) {
    if (event.target == modal || event.target == registerModal || event.target == absenceModal) {
        modal.style.display = "none"; 
        registerModal.style.display = "none";
        absenceModal.style.display = 'none'; 
    }
}

// Absence management functionality
var absenceTableBody = document.getElementById('absence-tbody');
var absenceData = [];

function renderAbsenceTable() {
    absenceTableBody.innerHTML = '';
    absenceData.forEach((entry, index) => {
        var row = document.createElement('tr');
        row.innerHTML = `
            <td>${entry.absentTeacher}</td>
            <td>${entry.replacementTeacher}</td>
            <td>${entry.date}</td>
            <td>
                <button onclick="removeAbsence(${index})">Odstrani</button>
            </td>
        `;
        absenceTableBody.appendChild(row);
    });
}

function removeAbsence(index) {
    absenceData.splice(index, 1);
    renderAbsenceTable();
}

addAbsenceBtn.onclick = function() {
    document.getElementById('absent-teacher').value = '';
    document.getElementById('replacement-teacher').value = '';
    absenceModal.style.display = 'block';
}

saveAbsenceBtn.onclick = function() {
    var absentTeacher = document.getElementById('absent-teacher').value;
    var replacementTeacher = document.getElementById('replacement-teacher').value;
    var absenceDate = document.getElementById('absence-date').value;
    
    if (absentTeacher && replacementTeacher && absenceDate) {
        absenceData.push({
            absentTeacher: absentTeacher,
            replacementTeacher: replacementTeacher,
            date: absenceDate
        });
        renderAbsenceTable();
        absenceModal.style.display = 'none';
    }
}

spans[1].onclick = function() {
    absenceModal.style.display = 'none';
}

window.onclick = function(event) {
    if (event.target == absenceModal) {
        absenceModal.style.display = 'none';
    }
}

renderAbsenceTable();

// Schedule dropdown functionality
var schedules = {
    "R1a": [
        ["07:10 - 07:55", "Matematika", "Angleščina", "Fizika", "Zgodovina", "Biologija"],
        ["08:00 - 08:45", "Kemija", "Telesna vzgoja", "Geografija", "Likovna umetnost", "Fizika"],
        ["08:50 - 09:35", "Angleščina", "Matematika", "Zgodovina", "Kemiija", "Geografija"],
        ["09:40 - 10:25", "Biologija", "Telesna vzgoja", "Učbenik", "Likovna umetnost", "Matematika"],
        ["10:30 - 11:15", "Zgodovina", "Kemija", "Angleščina", "Telesna vzgoja", "Biologija"],
        ["11:20 - 12:05", "Likovna umetnost", "Fizika", "Matematika", "Geografija", "Kemiija"],
        ["12:10 - 12:55", "Matematika", "Zgodovina", "Kemiija", "Angleščina", "Likovna umetnost"],
        ["13:00 - 13:45", "Telesna vzgoja", "Biologija", "Geografija", "Fizika", "Zgodovina"],
        ["13:50 - 14:35", "Učbenik", "Matematika", "Kemiija", "Likovna umetnost", "Telesna vzgoja"],
        ["14:40 - 15:35", "Geografija", "Fizika", "Biologija", "Telesna vzgoja", "Matematika"]
    ],
    "R1b": [
        ["07:10 - 07:55", "Fizika", "Matematika", "Kemija", "Zgodovina", "Biologija"],
        ["08:00 - 08:45", "Angleščina", "Učbenik", "Telesna vzgoja", "Likovna umetnost", "Fizika"],
        ["08:50 - 09:35", "Matematika", "Zgodovina", "Kemija", "Telesna vzgoja", "Geografija"],
        ["09:40 - 10:25", "Biologija", "Likovna umetnost", "Geografija", "Matematika", "Angleščina"],
        ["10:30 - 11:15", "Kemija", "Fizika", "Zgodovina", "Telesna vzgoja", "Biologija"],
        ["11:20 - 12:05", "Matematika", "Geografija", "Angleščina", "Učbenik", "Likovna umetnost"],
        ["12:10 - 12:55", "Fizika", "Zgodovina", "Kemija", "Telesna vzgoja", "Matematika"],
        ["13:00 - 13:45", "Biologija", "Likovna umetnost", "Geografija", "Angleščina", "Zgodovina"],
        ["13:50 - 14:35", "Telesna vzgoja", "Kemija", "Matematika", "Fizika", "Geografija"],
        ["14:40 - 15:35", "Zgodovina", "Biologija", "Telesna vzgoja", "Matematika", "Angleščina"]
    ],
    "R2a": [
        ["07:10 - 07:55", "Matematika", "Geografija", "Telesna vzgoja", "Angleščina", "Fizika"],
        ["08:00 - 08:45", "Likovna umetnost", "Kemija", "Zgodovina", "Biologija", "Matematika"],
        ["08:50 - 09:35", "Geografija", "Učbenik", "Matematika", "Telesna vzgoja", "Likovna umetnost"],
        ["09:40 - 10:25", "Kemija", "Biologija", "Zgodovina", "Matematika", "Fizika"],
        ["10:30 - 11:15", "Telesna vzgoja", "Geografija", "Angleščina", "Likovna umetnost", "Biologija"],
        ["11:20 - 12:05", "Matematika", "Zgodovina", "Kemija", "Fizika", "Angleščina"],
        ["12:10 - 12:55", "Geografija", "Biologija", "Telesna vzgoja", "Zgodovina", "Likovna umetnost"],
        ["13:00 - 13:45", "Kemija", "Matematika", "Angleščina", "Fizika", "Učbenik"],
        ["13:50 - 14:35", "Zgodovina", "Biologija", "Geografija", "Telesna vzgoja", "Matematika"],
        ["14:40 - 15:35", "Likovna umetnost", "Kemija", "Angleščina", "Matematika", "Biologija"]
    ],
    // Repeat for other classes (R2b, R3a, R3b, R4a, R4b)
};

// Function to populate the schedule based on selected class
function loadSchedule(className) {
    var schedule = schedules[className];
    scheduleBody.innerHTML = '';
    schedule.forEach(function (period) {
        var row = document.createElement('tr');
        period.forEach(function (subject) {
            var cell = document.createElement('td');
            cell.textContent = subject;
            row.appendChild(cell);
        });
        scheduleBody.appendChild(row);
    });
}

var classSelect = document.getElementById('class-select');
var scheduleBody = document.getElementById('schedule-body');

classSelect.onchange = function() {
    loadSchedule(this.value);
};

// Initialize with the first class
loadSchedule("R1a");
