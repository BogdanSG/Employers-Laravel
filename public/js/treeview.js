jQuery(function ($) {

    let Api = $('meta[name=api_token]').attr("content");
    let DragAndDropButton = $('#DragAndDropButton')[0];
    let Employee = $('#Employee')[0];
    let Chief = $('#Chief')[0];
    let EmployeeID = $('#EmployeeID')[0];
    let ChiefID = $('#ChiefID')[0];
    let SendFrom = $('#SendFrom')[0];

    let btnDanger = 'btn-danger';
    let btnPrimary = 'btn-primary';

    let dad = localStorage.getItem('drag_and_drop');

    let DragAndDrop = false;

    if(dad){

        if(DragAndDropButton){

            DragAndDropButton.classList.remove(btnDanger);
            DragAndDropButton.classList.remove(btnPrimary);

            if(dad === btnDanger){

                DragAndDropButton.classList.add(btnDanger);
                DragAndDropButton.innerHTML = 'Disable';
                DragAndDrop = false;

            }//if
            else if(dad === btnPrimary){

                DragAndDropButton.classList.add(btnPrimary);
                DragAndDropButton.innerHTML = 'Enable';
                DragAndDrop = true;

            }//else if

        }//DragAndDropButton

    }//if
    else {

        if(DragAndDropButton){

            DragAndDropButton.classList.add(btnPrimary);
            DragAndDropButton.innerHTML = 'Enable';
            DragAndDrop = true;

        }//if

    }//else

    if(DragAndDropButton){

        DragAndDropButton.addEventListener('click', function () {

            for(let i = 0; i < DragAndDropButton.classList.length; i++){

                console.log(DragAndDropButton.classList.item(i));

                if(DragAndDropButton.classList[i] === btnPrimary){

                    DragAndDropButton.classList.remove(btnPrimary);
                    DragAndDropButton.classList.add(btnDanger);
                    DragAndDropButton.innerHTML = 'Disable';
                    localStorage.setItem('drag_and_drop', btnDanger);
                    DragAndDrop = false;
                    break;

                }//if
                else if(DragAndDropButton.classList[i] === btnDanger){

                    DragAndDropButton.classList.remove(btnDanger);
                    DragAndDropButton.classList.add(btnPrimary);
                    DragAndDropButton.innerHTML = 'Enable';
                    localStorage.setItem('drag_and_drop', btnPrimary);
                    DragAndDrop = true;
                    break;

                }//else if

            }//for

            location.reload();

        });

    }//if

    let employees = new shield.RecursiveDataSource({
        remote: {
            read: function (params, success, error, extra) {
                if (extra) {

                    $.ajax({
                        contentType: 'application/json',
                        dataType: 'json',
                        data: JSON.stringify({
                            id: extra.parent.data
                        }),
                        url: "/api/tree-employee",
                        type: 'POST'
                    }).done(function (data) {

                        if(data && data.length > 0){

                            nodes = [];

                            data.forEach(item => {

                                nodes.push({
                                    text: `${item.FirstName} ${item.LastName} ${item.SurName} (${item.Position}) (${item.CountEmployees})`,
                                    data: item.EmployeeID,
                                    hasChildren: item.CountEmployees > 0 ? true : false,
                                    items: employees
                                });

                            });

                            success(nodes, false, extra);

                        }//if
                        else {

                            success([], false, extra);

                        }//else

                        success(data, false, extra);

                    }).fail(function () {

                        success([], false, extra);

                    });

                }//if
            }
        }
    });

    let data =  [ {
            text: "Employees", data: 0, hasChildren: true, items: employees
        },
    ];
    $("#treeview").shieldTreeView({
        dataSource: data,
        dragDrop: Api && DragAndDrop ? true : false,
        events: {
            select: !DragAndDrop ? function (e) {

                if(e.item.data){

                    window.location.href = `/single-employee/${e.item.data}`

                }//if

            } : null,
            drop: Api && DragAndDrop ? function (e) {

                if(e.sourceNode && e.targetNode){

                    let sourceNode = this.getItem(e.sourceNode);
                    let targetNode = this.getItem(e.targetNode);

                    if(sourceNode && targetNode && Employee && Chief && EmployeeID && ChiefID && SendFrom){

                        let employeeID = sourceNode.data;
                        let chiefID = targetNode.data;

                        Employee.innerHTML = `<span class="sui-treeview-item-text sui-draggable sui-droppable">${e.sourceNode[0].innerText}</span>`;
                        Chief.innerHTML = `<span class="sui-treeview-item-text sui-draggable sui-droppable">${e.targetNode[0].innerText}</span>`;

                        EmployeeID.value = employeeID;
                        ChiefID.value = chiefID;

                        SendFrom.classList.remove('hiden-elem');

                    }//if

                }//if

            } : null
        }
    });

});