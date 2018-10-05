$(document).ready(function () {

    let FirstName = $('#FirstName')[0];
    let LastName = $('#LastName')[0];
    let SurName = $('#SurName')[0];
    let ChiefID = $('#ChiefID')[0];
    let EmploymentDate = $('#EmploymentDate')[0];
    let Salary = $('#Salary')[0];
    let Update = $('#Update')[0];
    let Delete = $('#Delete')[0];
    let FileImput = $('#FileImput');
    let Chief = $('#Chief')[0];
    let Position = $('#Position')[0];

    let Api = $('meta[name=api_token]').attr("content");

    let EditButton = $('#Edit')[0];

    if(ChiefID){

        ChiefID.addEventListener('input', function (event) {

            if(Api){

                $.ajax({
                    contentType: 'application/json',
                    dataType: 'json',
                    data: JSON.stringify({
                        id: event.srcElement.value
                    }),
                    url: `/api/new-employee-position-chief/?api_token=${Api}`,
                    type: 'POST'
                }).done(function (data) {

                    if(data.Chief && data.Position){

                        if(Chief){

                            Chief.innerHTML = `${data.Chief.FirstName} ${data.Chief.LastName} ${data.Chief.SurName}`;

                        }//if

                        if(Position){

                            Position.innerHTML = data.Position;

                        }//if

                    }//if
                    else {

                        if(Chief){

                            Chief.innerHTML = '';

                        }//if

                        if(Position){

                            Position.innerHTML = '';

                        }//if


                    }//else

                }).fail(function () {

                    if(Chief){

                        Chief.innerHTML = '';

                    }//if

                    if(Position){

                        Position.innerHTML = '';

                    }//if

                });

            }//Api

        });

    }//if

    if(Update){

        Update.addEventListener('click', function (event) {

            if(!confirm('Are you sure you want to update an employee?')){

                event.preventDefault();

            }//if

        });

    }//if

    if(Delete){

        Delete.addEventListener('click', function (event) {

            if(!confirm('Are you sure you want to delete an employee?')){

                event.preventDefault();

            }//if

        });

    }//if

    if(EditButton){

        EditButton.addEventListener('click', function () {

            if(FirstName){

                FirstName.disabled = !FirstName.disabled;

            }//if

            if(LastName){

                LastName.disabled = !LastName.disabled;

            }//if

            if(SurName){

                SurName.disabled = !SurName.disabled;

            }//if

            if(ChiefID){

                ChiefID.disabled = !ChiefID.disabled;

            }//if

            if(EmploymentDate){

                EmploymentDate.disabled = !EmploymentDate.disabled;

            }//if

            if(Salary){

                Salary.disabled = !Salary.disabled;

            }//if

            if(Update){

                Update.disabled = !Update.disabled;

            }//if

            if(FileImput){

                FileImput.toggleClass('hiden-elem');

            }//if

        });

    }//if

    let employeeImage = $('#employeeImage')[0];
    let employeeImageLabel = $('#employeeImageLabel')[0];

    if(employeeImage){

        employeeImage.addEventListener('change', function (event) {

            if(employeeImageLabel){

                employeeImageLabel.innerHTML = event.srcElement.value;

            }//if

        });

    }//if


});