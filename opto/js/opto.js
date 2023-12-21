/************FORMULARIO PARA CRIAR UM NOVO TASK************* */

$("#opto-create-task").submit(function(event){
    event.preventDefault();
    //alert($("#createTaskProjectID").val());
    var taskCreateTitle = $("#taskCreateTitle").val();
    var taskCreateMember = $("#taskCreateMember").val();
    var taskCreateDueDate = $("#taskCreateDueDate").val();
    var createTaskProjectID = $("#createTaskProjectID").val();

    $.ajax({
        type: 'post',
        url: 'opto/php/addTask.php',
        crossDomain: true,
        data: 'title='+taskCreateTitle+'&member='+taskCreateMember+'&dueDate='+taskCreateDueDate+'&taskID='+createTaskProjectID,
        success: function(retorno){
            if(retorno == 'OK'){
                $("#taskCreateTitle").val("");
                $("#taskCreateMember").val("");
                $("#taskCreateDueDate").val("");
                $("#createTaskProjectID").val("");
                $('#opto-create-task').magnificPopup('close');
            }else{
                alert("There was a problem and it was not possible to create this task!");
            }
        }
    })
})



function getProjects(){
    $.ajax({
        type: "GET",
        dataType: "json",
        url: "opto/php/getProjects.php",
        crossDomain: true,
        success: function(retorno){
            //alert(retorno[0].projectName);
            //$("#recebeProjects").html(retorno[0].projectName);
            $("#recebeProjects").empty();
            //console.log( retorno );
            for(var i=0;retorno.length>i;i++){
                //alert(projectID)
                $("#recebeProjects").append('<div class="opto-project-container"><div class="opto-project-header"><div class="opto-project-title-container"><h2 class="opto-project-title">'+retorno[i].projectName+'</h2><div class="opto-project-timeline"><div class="opto-project-timeline-borderline row"><a href="#" class="opto-project-timeline-format opto-project-timeline-production col-4"><div>PRODUCTION</div></a><a href="#" class="opto-project-timeline-format opto-project-timeline-proof col-4"><div>PROOF</div>&nbsp;<i style="color: green;" class="fa-solid fa-thumbs-up"></i><i style="color: yellow;" class="fa-solid fa-hourglass-start"></i><i style="color: red;" class="fa-solid fa-thumbs-down"></i></a><a href="#" class="opto-project-timeline-format opto-project-timeline-complete col-4"><div>COMPLETE</div></a></div></div></div><div class="opto-projects-images"><div class="opto-projects-images-member"><img src="opto/image/members/1135825450israel.jpg"></div><div class="opto-projects-images-client"><img src="opto/image/clients/1498240461opto.jpg"></div></div><div class="opto-projects-toosl-right"><div class="opto-projects-toosl-right-icon"><a href="#"><i class="fa-solid fa-flag"></i></a></div><div class="opto-projects-toosl-right-icon"><a href="#"><i class="fa-solid fa-trash"></i></a></div><div class="opto-projects-toosl-right-icon"><a href="#"><i class="fa-solid fa-pen-to-square"></i></a></div><div class="opto-projects-toosl-right-icon"><a href="#" onClick="return openProject('+retorno[i].id+');"><i class="fa-regular fa-folder-open"></i></a></div></div><div class="opto-projects-clock-right"><div class="opto-projects-toosl-clock-icon"><i class="fa-solid fa-clock">&nbsp;</i>02:25:40</div></div></div><div class="opto-project-body" id="opto-project-body'+retorno[i].id+'"><div class="opto-project-tasks"><div>Tasks List &nbsp;<span><a onclick="return openModalCreateTask('+retorno[i].id+');" href="#"><i class="fa-solid fa-plus"></i></a></span></div><div id="recebeTasks'+retorno[i].id+'"></div></div></div></div>');

                getTasks(retorno[i].id);

            }
        }
    })    
}



function getTasks(projectID){
    $.ajax({
        type: "POST",
        dataType: "json",
        url: "opto/php/getTasks.php",
        data: "project_id="+projectID,
        crossDomain: true,
        success: function(retorno){
            for(var i=0;retorno.length>i;i++){
                $("#recebeTasks"+projectID).append('<div class="opto-project-tasks-list-container"><div class="opto-project-tasks-listView"><div class="opto-projects-tasks-listView-images-member"><img src="opto/image/members/1135825450israel.jpg"></div><div class="opto-projects-tasks-listView-title">'+retorno[i].title+'</div><div class="opto-projects-tasks-listView-tools"><a href="#"><i class="fa-solid fa-trash"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" onClick="return openTask(1);" id="opto-projects-tasks-open"><i class="fa-regular fa-folder-open"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="#"><i class="fa-solid fa-folder-closed"></i></a></div><div class="opto-projects-tasks-listView-progressBar"><progress id="file" value="32" max="100"> 32% </progress></div></div></div><!--INICIO DOS STEPS--><div class="opto-project-steps" id="opto-project-steps1"><div class="opto-project-steps-list"><input class="opto-project-steps-checkbox" type="checkbox"><p class="opto-project-steps-title">Titulo do Step</p><div class="opto-project-steps-delete"><i class="fa-solid fa-trash"></i></div></div> </div>');
            }
        }
    })    
}





function openModalCreateTask(taskID){
    //alert(taskID);
    $.magnificPopup.open({
        items: {
            src: $('#opto-create-task'),
        },
        type: 'inline',
        preloader: false,
        modal: true,
    });

    $("#createTaskProjectID").val(taskID);
}

function openProject(id){
    $("#opto-project-body"+id).toggle();
}
function openTask(id){
    $("#opto-project-steps"+id).toggle();
}

/***************FUNÇÃO QU ENVIA PARA UMA PAGINA*************** */
function goToPage(url){
    window.location.href=url;
}


function changeLayoutColunm(id){
    if(id == 1){
        $("#opto-project-list-global").addClass("col-lg-12");
        $("#opto-project-list-global").removeClass("col-lg-9");
        $("#rightColumn2").show();
        $("#rightColumn1").show();
        $("#rightColumn1").addClass("col-lg-6");
        $("#rightColumn1").removeClass("col-lg-3");
        $("#rightColumn2").addClass("col-lg-6");
        $("#rightColumn2").removeClass("col-lg-3");
    }else if(id == 2){
        $("#opto-project-list-global").removeClass("col-lg-12");
        $("#opto-project-list-global").addClass("col-lg-9");
        $("#rightColumn1").show();
        $("#rightColumn1").addClass("col-lg-3");
        $("#rightColumn1").removeClass("col-lg-6");
        $("#rightColumn2").hide();
    }else if(id == 3){
        $("#opto-project-list-global").removeClass("col-lg-12");
        $("#opto-project-list-global").addClass("col-lg-9");
        $("#rightColumn2").show();
        $("#rightColumn2").addClass("col-lg-3");
        $("#rightColumn2").removeClass("col-lg-6");
        $("#rightColumn1").hide();
    }
}





