jQuery(function ($) {

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
        dataSource: data
    });
});