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
