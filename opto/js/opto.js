/************FORMULARIO PARA CRIAR UM NOVO TASK************* */

$("#opto-create-task").submit(function(event){
    event.preventDefault();
    //alert($("#createTaskProjectID").val());
    var taskCreateTitle = $("#taskCreateTitle").val();
    var taskCreateMember = $("#taskCreateMember").val();
    var taskCreateDueDate = $("#taskCreateDueDate").val();
    var createTaskProjectID = $("#createTaskProjectID").val();

    $.ajax({
        type: 'GET',
        url: 'opto/php/addTask.php',
        crossDomain: true,
        data: `title=${taskCreateTitle}&member=${taskCreateMember}&dueDate=${taskCreateDueDate}&projectID=${createTaskProjectID}`,
        success: function(retorno){
            if(retorno == 'OK'){
                $("#taskCreateTitle").val("");
                $("#createTaskProjectID").val("");
                getTasks(createTaskProjectID);
                $('#opto-create-task').magnificPopup('close');
            }else{
                $("#taskCreateTitle").val("");
                alert("There was a problem and it was not possible to create this task!");
            }
        }
    })
})


/************FORMULARIO PARA CRIAR UM NOVO TASK PRESET EDIT MODE************* */

$("#opto-create-task-editMode").submit(function(event){
    event.preventDefault();
    //alert($("#createTaskProjectID").val());
    var taskCreateTitle = $("#taskCreateTitleEditMode").val();
    var taskCreateMember = $("#taskCreateMemberEditMode").val();
    var taskCreateDueDate = $("#taskCreateDueDateEditMode").val();
    var createTaskProjectID = $("#createTaskProjectIDEditMode").val();

    $.ajax({
        type: 'GET',
        url: 'opto/php/addTaskEditMode.php',
        crossDomain: true,
        data: 'title='+taskCreateTitle+'&member='+taskCreateMember+'&dueDate='+taskCreateDueDate+'&projectID='+createTaskProjectID,
        success: function(retorno){
            if(retorno == 'OK'){
                $("#taskCreateTitleEditMode").val("");
                $("#taskCreateMemberEditMode").val("");
                $("#taskCreateDueDateEditMode").val("");
                $("#createTaskProjectIDEditMode").val("");
                getTasksEditMode(createTaskProjectID);
                $('#opto-create-task').magnificPopup('close');
            }else{
                $("#taskCreateTitleEditMode").val("");
                $("#taskCreateMemberEditMode").val("");
                $("#taskCreateDueDateEditMode").val("");
                $("#createTaskProjectIDEditMode").val("");
                alert("There was a problem and it was not possible to create this task!");
            }
        }
    })
})


/************FORMULARIO PARA CRIAR UM NOVO STEP************* */

$("#opto-form-create-step").submit(function(event){
    event.preventDefault();

    var stepCreateTitle = $("#stepCreateTitle").val();
    var createStepTaskID = $("#createStepTaskID").val();

    $.ajax({
        type: 'GET',
        url: 'opto/php/addStep.php',
        crossDomain: true,
        data: 'title='+stepCreateTitle+'&taskID='+createStepTaskID,
        success: function(retorno){
            if(retorno == 'OK'){
                $("#stepCreateTitle").val("");
                $("#createStepTaskID").val("");
                getSteps(createStepTaskID);
                $('#opto-create-step').magnificPopup('close');
            }else{
                alert("There was a problem and it was not possible to create this step!");
            }
        }
    })
})


/************FORMULARIO PARA CRIAR UM NOVO STEP EDIT MODE************* */

$("#opto-form-create-step-editMode").submit(function(event){
    event.preventDefault();

    var stepCreateTitle = $("#stepCreateTitleEditMode").val();
    var createStepTaskID = $("#createStepTaskIDEditMode").val();

    $.ajax({
        type: 'GET',
        url: 'opto/php/addStepEditMode.php',
        crossDomain: true,
        data: 'title='+stepCreateTitle+'&taskID='+createStepTaskID,
        success: function(retorno){
            if(retorno == 'OK'){
                $("#stepCreateTitleEditMode").val("");
                $("#createStepTaskIDEditMode").val("");
                getStepsEditmode(createStepTaskID);
                $('#opto-create-step-editMode').magnificPopup('close');
            }else{
                alert("There was a problem and it was not possible to create this step!");
            }
        }
    })
})


/***********************************PEGA PROJETOS************************ */
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
                //alert(retorno[i].openProject)
                $("#recebeProjects").append('<div class="opto-project-container"><div class="opto-project-header"><div class="opto-project-title-container"><h2 class="opto-project-title">'+retorno[i].projectName+'</h2><div class="opto-project-timeline"><div class="opto-project-timeline-borderline row"><a href="#" class="opto-project-timeline-format opto-project-timeline-production col-4"><div>PRODUCTION</div></a><a href="#" class="opto-project-timeline-format opto-project-timeline-proof col-4"><div>PROOF</div>&nbsp;<i style="color: green;" class="fa-solid fa-thumbs-up"></i><i style="color: yellow;" class="fa-solid fa-hourglass-start"></i><i style="color: red;" class="fa-solid fa-thumbs-down"></i></a><a href="#" class="opto-project-timeline-format opto-project-timeline-complete col-4"><div>COMPLETE</div></a></div></div></div><div class="opto-projects-images"><div class="opto-projects-images-member"><img src="opto/image/members/'+retorno[i].memberImage+'"></div><div class="opto-projects-images-client"><img src="opto/image/clients/'+retorno[i].clientImage+'"></div></div><div class="opto-projects-toosl-right"><div class="opto-projects-toosl-right-icon"><a href="#"><i class="fa-solid fa-flag"></i></a></div><div class="opto-projects-toosl-right-icon"><a href="#" onClick="return openModalDelete(2, '+retorno[i].id+');"><i class="fa-solid fa-trash"></i></a></div><div class="opto-projects-toosl-right-icon"><a href="#"><i class="fa-solid fa-pen-to-square"></i></a></div><div class="opto-projects-toosl-right-icon"><a href="#" onClick="return openProject('+retorno[i].id+');"><i class="fa-regular fa-folder-open"></i></a></div></div><div class="opto-projects-clock-right"><div class="opto-projects-toosl-clock-icon"><i class="fa-solid fa-clock">&nbsp;</i><span id="recebeRelogio'+retorno[i].id+'">00:00:00</span></div></div></div><div class="opto-project-body" id="opto-project-body'+retorno[i].id+'"><div class="opto-project-tasks"><div><b>TASKS LIST</b> &nbsp;<span><a onclick="return openModalCreateTask('+retorno[i].id+');" href="#"><i class="fa-solid fa-plus"></i></a></span></div><div id="recebeTasks'+retorno[i].id+'"></div></div></div></div>');

                if(retorno[i].openProject == 'open'){
                    $("#opto-project-body"+retorno[i].id).show();
                }
                
                //countHours(retorno[i].id);
                getTasks(retorno[i].id);

            }
        }
    })    
}


function changeView(type, id){
    alert(type)
    //SE TYPE = 0 => MOSTRA TODOS OS PROJETOS
    //SE TYPE = 1 => MOSTRA PROJETOS SHARED WITH ME
    //SE TYPE = 2 => MOSTRA PROJETOS FILTRADOS POR MEMBRO
    //SE TYPE = 3 => MOSTRA PROJETOS FILTRADOS POR CLIENT
    $.ajax({
        type: 'GET',
        url: 'opto/php/changeView.php',
        data: 'type='+type+'&id='+id,
        crossDomain: true,
        success: function(retorno){
            getProjects();
        }
    })
}

function changeOrdering(type){
    alert(type)
    //SE TYPE = 0 => ORDENA POR DATA DE CRIAÇÂO
    //SE TYPE = 1 => ORDENA POR PRIORIDADE (BANDEIRINHA)
    $.ajax({
        type: 'GET',
        url: 'opto/php/changeOrdering.php',
        data: 'type='+type,
        crossDomain: true,
        success: function(retorno){
            getProjects();
        }
    })
}


/***********************************PEGA PROJETOS PRESET EDIT MODE************************ */
function getProjectsEditMode(){
    $.ajax({
        type: "GET",
        dataType: "json",
        url: "opto/php/getProjectsEditMode.php",
        crossDomain: true,
        success: function(retorno){

            $("#recebePresetEditMode").empty();

            for(var i=0;retorno.length>i;i++){
                $("#recebePresetEditMode").append('<div class="opto-project-container"><div class="opto-project-header"><div class="opto-project-title-container-editMode"><h2 class="opto-project-title">'+retorno[i].projectName+'</h2></div><div class="opto-projects-toosl-right"><div class="opto-projects-toosl-right-icon"><a href="#"><i class="fa-solid fa-trash"></i></a></div><div class="opto-projects-toosl-right-icon"><a href="#"><i class="fa-solid fa-pen-to-square"></i></a></div><div class="opto-projects-toosl-right-icon"><a href="#" onClick="return openProjectEditMode('+retorno[i].id+');"><i class="fa-regular fa-folder-open"></i></a></div></div></div><div class="opto-project-body" id="opto-project-body-editMode'+retorno[i].id+'"><div class="opto-project-tasks"><div>Tasks List &nbsp;<span><a onclick="return openModalCreateTaskEditMode('+retorno[i].id+');" href="#"><i class="fa-solid fa-plus"></i></a></span></div><div id="recebeTasksEditMode'+retorno[i].id+'"></div</div></div></div>');

                if(retorno[i].openProject == 'open'){
                    $("#opto-project-body"+retorno[i].id).show();
                }
                
                //countHours(retorno[i].id);
                getTasksEditMode(retorno[i].id);

            }
        }
    })    
}


/***********************************PEGA TASKS************************ */
function getTasks(projectID){
    $.ajax({
        type: "POST",
        dataType: "json",
        url: "opto/php/getTasks.php",
        data: "project_id="+projectID,
        crossDomain: true,
        success: function(retorno){
            $("#recebeTasks"+projectID).empty();
            if(retorno.length == 0){
                $("#recebeTasks"+projectID).html('<p>There is no task for this project</p>');
            }else{ 

                var deleteTipo = '0';

                for(var i=0;retorno.length>i;i++){

                    $("#recebeTasks"+projectID).append('<div class="opto-project-tasks-list-container"><div class="opto-project-tasks-listView"><div class="opto-projects-tasks-listView-images-member"><img src="opto/image/members/'+retorno[i].image+'"></div><div class="opto-projects-tasks-listView-title"><b>'+retorno[i].title+'</b></div><div class="opto-projects-tasks-listView-tools"><div id="recebe-icon-playStop'+retorno[i].id+'"><a href="#" onClick="return playTask('+projectID+', '+retorno[i].id+', '+retorno[i].horas+', '+retorno[i].minutos+', '+retorno[i].segundos+');"><i class="fa-solid fa-play"></i></a></div>&nbsp;&nbsp;&nbsp;&nbsp;<a href="#"><i class="fa-solid fa-flag"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" onClick="return openModalDelete(0, '+retorno[i].id+');"><i class="fa-solid fa-trash"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" onClick="return openTask('+retorno[i].id+');" id="opto-projects-tasks-open"><i class="fa-regular fa-folder-open"></i></a></div><div class="opto-projects-tasks-listView-progressBar"><div data="'+retorno[i].horas+':'+retorno[i].minutos+':'+retorno[i].segundos+'" id="opto-clock-task'+retorno[i].id+'" class="opto-clock-task">'+retorno[i].horas+':'+retorno[i].minutos+':'+retorno[i].segundos+'</div></div></div></div><!--INICIO DOS STEPS--><div class="opto-project-steps" id="opto-project-steps'+retorno[i].id+'"> </div>');

                    if(retorno[i].openTask == 'open'){
                        $("#opto-project-steps"+retorno[i].id).show();
                    }

                    
                    countHours(projectID);
                    getSteps(retorno[i].id);

                    if(retorno[i].play == 1){
                        //alert(retorno[i].segundos);
                        playTask(projectID, retorno[i].id, retorno[i].horas, retorno[i].minutos, retorno[i].segundos);
                    }

                }
            } 
        }
    })    
}


/****************DELETE TASK*************** */
function openModalDelete(tipo, deleteID){
    //tipo = se é task ou step, 0 é task e 1 é step
    //deleteID = o id para ser deletado
    if(tipo == 0){
        $msg = 'Do You Really Want to Delete This Task?';
        $btn = '';
    }else if(tipo == 1){
        $msg = 'Do You Really Want to Delete This Step?';
    }else if(tipo == 2){
        $msg = 'Do You Really Want to Archive This Project?';
    }

    $.magnificPopup.open({
        items: {
            src: $('#modalDelete'),
        },
        type: 'inline',
        preloader: false,
        modal: true,
    });

    $("#recebeMSG").html($msg);
    $("#recebeCTNConfirm").html('<a href="#" onclick="return deleteThis('+tipo+', '+deleteID+')" class="btn btn-warning">Confirm</a>');
}

function deleteThis(tipo, deleteID){
    //tipo = se é task ou step, 0 é task e 1 é step
    //deleteID = o id para ser deletado
    $.ajax({
        type: 'GET',
        url: 'opto/php/deleteThis.php',
        data: 'tipo='+tipo+'&deleteID='+deleteID,
        crossDomain: true,
        success: function(retorno){
            if(retorno == 'OK'){
                $('#modalDelete').magnificPopup('close');
                getProjects();
            }
        }
    })
}


/***********************************PEGA TASKS************************ */
function getTasksEditMode(projectID){
    $.ajax({
        type: "GET",
        dataType: "json",
        url: "opto/php/getTasksEditMode.php",
        data: "project_id="+projectID,
        crossDomain: true,
        success: function(retorno){
            $("#recebeTasksEditMode"+projectID).empty();
            if(retorno.length == 0){
                $("#recebeTasksEditMode"+projectID).html('<p>There is no task for this project</p>');
            }else{ 
                for(var i=0;retorno.length>i;i++){
                    $("#recebeTasksEditMode"+projectID).append('<div class="opto-project-tasks-list-container"><div class="opto-project-tasks-listView"><div class="opto-projects-tasks-listView-images-member"><img src="opto/image/members/'+retorno[i].image+'"></div><div class="opto-projects-tasks-listView-title"><b>'+retorno[i].title+'</b></div><div class="opto-projects-tasks-listView-tools">&nbsp;&nbsp;&nbsp;<a href="#"><i class="fa-solid fa-trash"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" onClick="return openTaskEditmode('+retorno[i].id+');" id="opto-projects-tasks-open"><i class="fa-regular fa-folder-open"></i></a></div><div class="opto-projects-tasks-listView-progressBar"><div id="opto-clock-task'+retorno[i].id+'" class="opto-clock-task-editMode">'+retorno[i].horas+':'+retorno[i].minutos+':'+retorno[i].segundos+'</div></div></div></div><!--INICIO DOS STEPS--><div class="opto-project-steps" id="opto-form-create-step-editMode'+retorno[i].id+'"> </div>');

                    if(retorno[i].openTask == 'open'){
                        $("#opto-project-steps-editMode"+retorno[i].id).show();
                    }

                    getStepsEditMode(retorno[i].id);

                }
            } 
        }
    })    
}


function playTask(projectID, taskID, horas, minutos, segundos){

    window["hora"+taskID] = horas;
    window["minuto"+taskID] = minutos;
    window["segundo"+taskID] = segundos;

    $.ajax({
        type: 'GET',
        url: 'opto/php/playTask.php',
        data: 'taskID='+taskID,
        dataType: 'json',
        crossDomain: true,
        success: function(retorno){
                //alert(retorno[0].segundos)
                $("#recebe-icon-playStop"+taskID).html('<a href="#" onClick="return pauseTask('+projectID+', '+taskID+', '+window["hora"+taskID]+', '+window["minuto"+taskID]+', '+window["segundo"+taskID]+');"><i class="fa-solid fa-pause"></i></a>');
                $("#opto-clock-task"+taskID).removeClass('opto-clock-task');
                $("#opto-clock-task"+taskID).addClass('opto-clock-task-play');
                window["optoClock"+taskID] = setInterval(function(){
                    if(window["segundo"+taskID] < 60){
                        window["segundo"+taskID]++;
                    }
                    if(window["segundo"+taskID] == 60){
                        window["segundo"+taskID] = 0;
                        window["minuto"+taskID]++;
                    }
                    if(window["minuto"+taskID] == 60){
                        window["minuto"+taskID] = 0;
                        window["hora"+taskID]++;
                    }
            
                    if(window["segundo"+taskID] < 10){
                        var segFormat = '0'+window["segundo"+taskID];
                    }else{
                        var segFormat = window["segundo"+taskID];
                    }
                    if(window["minuto"+taskID] < 10){
                        var minFormat = '0'+window["minuto"+taskID];
                    }else{
                        var minFormat = window["minuto"+taskID];
                    }
                    if(window["hora"+taskID] < 10){
                        var horaFormat = '0'+window["hora"+taskID];
                    }else{
                        var horaFormat = window["hora"+taskID];
                    }
            
                    var valorFinalHoras = horaFormat+':'+minFormat+':'+segFormat;
                    var valorFinalHorasnoFormat = window["hora"+taskID]+':'+window["minuto"+taskID]+':'+window["segundo"+taskID];
            
                    $("#opto-clock-task"+taskID).html(valorFinalHoras);
                    $("#opto-clock-task"+taskID).attr("data", valorFinalHorasnoFormat);
                    $("#recebe-icon-playStop"+taskID).html('<a href="#" onClick="return pauseTask('+projectID+', '+taskID+', '+window["hora"+taskID]+', '+window["minuto"+taskID]+', '+window["segundo"+taskID]+');"><i class="fa-solid fa-pause"></i></a>');

                    $.ajax({
                        type: 'GET',
                        url: 'opto/php/updateClock.php',
                        data: 'taskID='+taskID+'&horas='+valorFinalHorasnoFormat,
                        dataType: 'text',
                        crossDomain: true,
                        success: function(retorno){

                        }
                    })
            
                } ,1000);
        }
    })
    
}


function pauseTask(projectID, taskID, horas, minutos, segundos){
    $("#recebe-icon-playStop"+taskID).html('<a href="#" onClick="return playTask('+projectID+', '+taskID+', '+horas+', '+minutos+', '+segundos+');"><i class="fa-solid fa-play"></i></a>');    
    $("#opto-clock-task"+taskID).addClass('opto-clock-task');
    $("#opto-clock-task"+taskID).removeClass('opto-clock-task-play');
    clearInterval(window["optoClock"+taskID]);
    var horaUpdate = $("#opto-clock-task"+taskID).attr("data");horaUpdate
    $.ajax({
        type: 'GET',
        url: 'opto/php/updateClock.php',
        data: 'taskID='+taskID+'&horas='+horaUpdate,
        dataType: 'text',
        crossDomain: true,
        success: function(retorno){
            countHours(projectID);
            //getTasks(retorno);
        }
    })
    $.ajax({
        type: 'GET',
        url: 'opto/php/pauseTask.php',
        data: 'taskID='+taskID+'&horas='+horas+'&minutos='+minutos+'&segundos='+segundos,
        dataType: 'text',
        crossDomain: true,
        success: function(retorno){
            countHours(projectID);
            //getTasks(retorno);
        }
    })
}


function countHours(projectiID){
    $.ajax({
        type: 'GET',
        url: 'opto/php/countHours.php',
        data: 'projectID='+projectiID,
        crossDomain: true,
        success: function(retorno){
            $("#recebeRelogio"+projectiID).html(retorno);
        }
    })
}


/****************WORKING NOWW*************** */
function workingNow(){
    $.ajax({
        type: 'GET',
        url: 'opto/php/workingNow.php',
        dataType: 'json',
        crossDomain: true,
        success: function(retorno){
            for(var i=0;retorno.length>i;i++){
                $("#recebe-working-now").html('<div class="opto-working-now-container"><div class="opto-working-now-image"><img class="opto-working-now-image" src="opto/image/members/'+retorno[i].memberImage+'" height="40" width="40"></div><div class="opto-working-now-name">'+retorno[i].memberFname+'&nbsp;'+retorno[i].memberLname+'</div><div class="opto-working-now-project">'+retorno[i].clientAbbreviation+retorno[i].projectYear+retorno[i].projectNumber+'</div></div>');
            }
        }
    })
}


/***********************************PEGA STEPS************************ */
function getSteps(taskID){
    $.ajax({
        type: "POST",
        dataType: "json",
        url: "opto/php/getSteps.php",
        data: "task_id="+taskID,
        crossDomain: true,
        success: function(retorno){
            $("#opto-project-steps"+taskID).html('<div><b>STEPS LIST</b> &nbsp;<span><a onclick="return openModalCreateStep('+taskID+');" href="#"><i class="fa-solid fa-plus"></i></a></span></div>');
            if(retorno.length == 0){
                $("#opto-project-steps"+taskID).html('<div><b>STEPS LIST</b> &nbsp;<span><a onclick="return openModalCreateStep('+taskID+');" href="#"><i class="fa-solid fa-plus"></i></a></span></div><div>There is no steps for this task</div>');
            }else{ 
                for(var i=0;retorno.length>i;i++){
                    if(retorno[i].checked == 1){
                        var checked = 'checked';
                    }else{
                        var checked = null;
                    }
                    $("#opto-project-steps"+taskID).append('<div class="opto-project-steps-list"><input data="'+retorno[i].id+'" '+checked+' class="opto-project-steps-checkbox checkedFunction'+retorno[i].id+'" type="checkbox"><p class="opto-project-steps-title">'+retorno[i].title+'</p><div class="opto-project-steps-delete"><a href="#" onClick="return openModalDelete(1, '+retorno[i].id+');"><i class="fa-solid fa-trash"></i></a></div></div>');

                    $(".checkedFunction"+retorno[i].id).click(function(){
                        var inputID = $(this).attr('data');
                        $.ajax({
                            type: "POST",
                            dataType: "html",
                            url: "opto/php/checkStep.php",
                            data: "step_id="+inputID,
                            crossDomain: true,
                            success: function(retorno){
                                getSteps(taskID);
                            }
                        }) 
                    })
                }
            } 
        }
    })    
}



/***********************************PEGA STEPS EDIT MODE************************ */
function getStepsEditMode(taskID){
    $.ajax({
        type: "POST",
        dataType: "json",
        url: "opto/php/getStepsEditMode.php",
        data: "task_id="+taskID,
        crossDomain: true,
        success: function(retorno){
            $("#opto-project-steps-edit-mode"+taskID).html('<div><b>STEPS LIST</b> &nbsp;<span><a onclick="return openModalCreateStepEditMode('+taskID+');" href="#"><i class="fa-solid fa-plus"></i></a></span></div>');
            if(retorno.length == 0){
                $("#opto-project-steps-edit-mode"+taskID).html('<div><b>STEPS LIST</b> &nbsp;<span><a onclick="return openModalCreateStepEditMode('+taskID+');" href="#"><i class="fa-solid fa-plus"></i></a></span></div><div>There is no steps for this task</div>');
            }else{ 
                for(var i=0;retorno.length>i;i++){
                    $("#opto-project-steps-edit-mode"+taskID).append('<div class="opto-project-steps-list"><input data="'+retorno[i].id+'" '+checked+' class="opto-project-steps-checkbox checkedFunction'+retorno[i].id+'" type="checkbox"><p class="opto-project-steps-title">'+retorno[i].title+'</p><div class="opto-project-steps-delete"><i class="fa-solid fa-trash"></i></div></div>');
                }
            } 
        }
    })    
}


/***********************************CHECK STEPS************************ */


function openModalCreateTask(projectID){
    //alert(taskID);
    $.magnificPopup.open({
        items: {
            src: $('#opto-create-task'),
        },
        type: 'inline',
        preloader: false,
        modal: true,
    });

    $("#createTaskProjectID").val(projectID);
}


function openModalCreateTaskEditMode(projectID){
    //alert(taskID);
    $.magnificPopup.open({
        items: {
            src: $('#opto-create-task-editMode'),
        },
        type: 'inline',
        preloader: false,
        modal: true,
    });

    $("#createTaskProjectIDEditMode").val(projectID);
}


function openModalCreateStep(taskID){
    //alert(taskID);
    $.magnificPopup.open({
        items: {
            src: $('#opto-create-step'),
        },
        type: 'inline',
        preloader: false,
        modal: true,
    });

    $("#createStepTaskID").val(taskID);
}


function openModalCreateStepEditMode(taskID){
    //alert(taskID);
    $.magnificPopup.open({
        items: {
            src: $('#opto-form-create-step-editMode'),
        },
        type: 'inline',
        preloader: false,
        modal: true,
    });

    $("#createStepTaskIDEditMode").val(taskID);
}


function openProject(id){
    $.ajax({
        type: 'GET',
        url: 'opto/php/openProject.php',
        data: 'project_id='+id,
        crossDomain: true,
        success: function(retorno){
            $("#opto-project-body"+id).toggle();
        }
    });
}

function openProjectEditMode(id){
    $.ajax({
        type: 'GET',
        url: 'opto/php/openProjectEditMode.php',
        data: 'project_id='+id,
        crossDomain: true,
        success: function(retorno){
            $("#opto-project-body-editMode"+id).toggle();
        }
    });
}


function openTask(id){
    $.ajax({
        type: 'GET',
        url: 'opto/php/openTasks.php',
        data: 'task_id='+id,
        crossDomain: true,
        success: function(retorno){
            $("#opto-project-steps"+id).toggle();
        }
    });
}

function openTaskEditmode(id){
    $.ajax({
        type: 'GET',
        url: 'opto/php/openTasksEditMode.php',
        data: 'task_id='+id,
        crossDomain: true,
        success: function(retorno){
            $("#opto-project-steps-edit-mode"+id).toggle();
        }
    });
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





