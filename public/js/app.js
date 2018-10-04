window.addEventListener( "pageshow", function ( event ) {

    let historyTraversal = event.persisted ||
        (typeof window.performance != "undefined" &&
            window.performance.navigation.type === 2 );
    if (historyTraversal) {

        window.location.reload();
    }//if

});