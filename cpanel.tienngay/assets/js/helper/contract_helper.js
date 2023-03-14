function get_type_interest(id) {
    switch(id) {
        case '2' : result = 'Lãi hàng tháng gốc cuối kỳ';
            break;
        case '1' : result = 'Lãi hàng tháng, gốc hàng tháng';
            break;
        default  : result = "";
            break;
       
    }
    return result;
}
