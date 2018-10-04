$(document).ready(function () {

    let LimitSelect = $('#LimitSelect')[0];
    let SortSelect = $('#SortSelect')[0];
    let SortTypeSelect = $('#SortTypeSelect')[0];
    let SearchSelect = $('#SearchSelect')[0];
    let DataInput = $('#DataInput')[0];
    let PrevButton = $('#PrevButton')[0];
    let NextButton = $('#NextButton')[0];
    let Table = $('#table')[0];

    let Limit = 10;
    let Offset = 0;
    let Sort = 'EmployeeID';
    let SortType = 'Asc';
    let Search = 'EmployeeID';
    let SearchData = '';

    let employeeList = [];

    if(LimitSelect){

        Limit = LimitSelect[0].value ? LimitSelect[0].value : Limit;

        LimitSelect.addEventListener('change', function (event) {

            Limit = +event.srcElement.value;

            getEmployeeList();

        });

    }//if

    if(SortSelect){

        Sort = SortSelect[0].value ? SortSelect[0].value : Sort;

        SortSelect.addEventListener('change', function (event) {

            Sort = event.srcElement.value;

            Offset = 0;

            getEmployeeList();

        });

    }//if

    if(SortTypeSelect){

        SortType = SortTypeSelect[0].value ? SortTypeSelect[0].value : SortType;

        SortTypeSelect.addEventListener('change', function (event) {

            SortType = event.srcElement.value;

            Offset = 0;

            getEmployeeList();

        });

    }//if

    if(SearchSelect){

        Search = SearchSelect[0].value ? SearchSelect[0].value : Search;

        SearchSelect.addEventListener('change', function (event) {

            Search = event.srcElement.value;

            if(DataInput){

                SearchData = DataInput.value = '';

            }//if

            Offset = 0;

            getEmployeeList();

        });

    }//if

    if(DataInput){

        SearchData = DataInput.value ? DataInput.value : SearchData;

        DataInput.addEventListener('input', function (event) {

            SearchData = event.srcElement.value;

            Offset = 0;

            getEmployeeList();

        });

    }//if

    if(PrevButton){

        PrevButton.addEventListener('click', function () {

            Offset -= +Limit;

            if(Offset < 0){

                Offset = 0;

            }//if
            else {

                getEmployeeList();

            }//else

        });

    }//if

    if(NextButton){

        NextButton.addEventListener('click', function () {

            if(employeeList.length > 0){

                Offset += +Limit;

                getEmployeeList();

            }//if

        });

    }//if

    function getEmployeeList() {

        $.ajax({
            contentType: 'application/json',
            dataType: 'json',
            data: JSON.stringify({
                offset: Offset,
                limit: Limit,
                orderBy: Sort,
                sort: SortType,
                search: Search,
                searchValue: SearchData,
            }),
            url: "/api/employee-list",
            type: 'POST'
        }).done(function (data) {

            if(Table){

                clearChild(Table);

                if(data && data.length > 0){

                    employeeList = data;

                    let htmlTable = '';

                    data.forEach(employee => {

                        htmlTable += `<tr>
                                        <th scope="row"><a href="/single-employee/${employee.EmployeeID}">${employee.EmployeeID}</a></th>
                                        <td><img src="${employee.employeeimg ? `/img/employees/${employee.employeeimg.ImgName}` : '/img/user.png'}" class="rounded mx-auto d-block" height="40"></td>
                                        <td>${employee.FirstName}</td>
                                        <td>${employee.LastName}</td>
                                        <td>${employee.SurName}</td>
                                        <td>${employee.position.Position}</td>
                                        <td>${employee.ChiefID ? 'True' : 'False'}</td>
                                        <td>${employee.Salary}</td>
                                        <td>${getNormalDate(employee.EmploymentDate)}</td>
                                      </tr>`;

                    });

                    Table.innerHTML = htmlTable;

                }//if
                else {

                    employeeList = [];

                }//else

            }//if

        }).fail(function () {

            if(Table){

                clearChild(Table);
                employeeList = [];

            }//if

        });

    }//getEmployeeList

    function getNormalDate(date) {

        if(date){

            date = date.replace('Z', '');
            date = date.replace('T', ' ');
            date = date.slice(0, date.lastIndexOf('.'));

            return date;

        }//if
        else {

            return '';

        }//else

    }//getNormalDate

    function clearChild(elem){

        while (elem.firstChild) {

            elem.removeChild(elem.firstChild);

        }//while

    }//clearChild

    getEmployeeList();

});