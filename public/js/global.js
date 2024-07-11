$wire.on('fnExecListener', (e) => {    
    let fnExec  = e.function;
    let evExec  = JSON.stringify({
        'target'    : e.target,
        'content'   : e.content
    });    

    setTimeout(() => {
        
        eval(`${ fnExec }(${ evExec })`);
    
    }, 12);
});

const xContent  = 'x-content-change';

const initClockpicker = () => {
    $('.clockpicker').clockpicker();
}

const initSelectpicker = () => {
    $('.selectpicker').selectpicker();
}

const showModal = (e) => {
    $('#' + e.target).modal('show');
}

const hideModal = (e) => {
    $('#' + e.target).modal('hide');
}

const toastMessage = (e) => {
    let msg = e.content;
    
    Swal.fire({
        type                : msg.type,
        title               : msg.title,
        html                : `<b>${ msg.text }</b>`,
        showConfirmButton   : false,
        timer               : 3000,
        toast               : true,
        position            : 'top-right',
    });
}

const alertDeleteItem = (e) => {
    let item    = e.content;

    Swal.fire({
        title               :`Estás apunto de eliminar ${ item.inModule }: ${ item.name }.`,
        text                :'¿Deseas continuar?',
        type                :'info',
        buttonsStyling      : false,
        reverseButtons      : true,
        showCancelButton    : true,
        showConfirmButton   : true,
        customClass         : {
            confirmButton   : 'btn btn-dark waves-effect waves-light float-right',
            cancelButton    : 'btn btn-danger waves-effect waves-light float-right mr-3'
        },
        confirmButtonText   : '<i class="fe-check mr-1"></i> Si',
        cancelButtonText    : '<i class="fe-x mr-1"></i> No',
    }).then(function(t){
            
        if (t.value) {
            
            $wire.dispatch(e.target, {id: item.id});

        }

    });
}

const selectRefresh = (select) => {
    select.selectpicker('refresh');
}

const selectSelected = (e) => {
    let selectTarget    = $(`#${ e.target }`);
    let optionsSelected = e.content;

    optionsSelected.forEach( val => {
        
        selectTarget.find(`option[value="${ val }"]`).prop('selected', true);

    });

    selectRefresh(selectTarget);
}

const selectOptions = (e) => {
    let selectTarget    = $(`#${ e.target }`);
    let listItems       = e.content;
    let options         = ``;
    
    listItems.forEach( item => {
        
        options += `<option value="${ item.id }">${ item.name }</option>`;

    });


    selectTarget.html(options);

    selectRefresh(selectTarget);
}

const selectSelectedDynamic = (e) => {
    let selectTarget    = $(`#${ e.target }`); 
    let optionsSelected = e.content;
   
    optionsSelected.forEach( val => {
        
        selectTarget.find(`option[value="${ val }"]`).prop('selected', true);

    });
        
    selectRefresh(selectTarget);
}

const selectOptionsDynamic = (e) => {
    let selectTarget    = $(`#${ e.target }`);
    let listItems       = e.content;
    let options         = ``;
    
    listItems.forEach( item => {
    
        options += `<option value="${ item.id }">${ item.name }</option>`;

    });
    
    selectTarget.html(options);

    selectRefresh(selectTarget);
}

const showTicket = (e) => {
    let selectTarget        = e.target;
    window.location.href    = `/sales/ticket/${selectTarget}`;
}

const randomNumber = (min, max) => {
    return Math.random() * (max - min) + min;
}

const randomBar = (date, lastClose) => {
    let open    = randomNumber(lastClose * 0.95, lastClose * 1.05);
    let close   = randomNumber(open * 0.95, open * 1.05);
    return {
        t: date.valueOf(),
        y: close
    };
}

const graphBarChart = (e) => {
    
    let selectTarget    = $(`#${ e.target }`)[0];
    let listItems       = e.content;
    let ctx             = selectTarget.getContext('2d');
    let barChart        = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: listItems.labelNames,
            datasets: [{
                    label: listItems.graphName,
                    backgroundColor: "#f0643b",
                    borderColor: "#f0643b",
                    hoverBackgroundColor: "#f0643b",
                    hoverBorderColor: "#f0643b",
                    data: listItems.dataQuantities,
                }, 
            ]
        },
        options: {
            maintainAspectRatio: false,
            legend: {
                display: false
            },
            scales: {
                yAxes: [{
                    gridLines: {
                        display: false
                    },
                    stacked: false,
                    ticks: {
                        stepSize: 20
                    }
                }],
                xAxes: [{
                    barPercentage: 0.7,
                    categoryPercentage: 0.5,
                    stacked: false,
                    gridLines: {
                        color: "rgba(0,0,0,0.01)"
                    }
                }]
            }
        }
    });

}