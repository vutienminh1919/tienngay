<?php


namespace App\Models;


class DraftNl extends BaseModel
{
    const COLUMN_CONTRACT_ID = 'contract_id';
    const COLUMN_INVESTOR_ID = 'investor_id';
    const COLUMN_INVESTMENT_ID = 'investment_id';
    const COLUMN_STATUS = 'status';
    const COLUMN_ORDER_CODE = 'order_code';
    const COLUMN_CLIENT_CODE = 'client_code';
    const COLUMN_BANK_CODE_NL = 'bank_code_nl';
    const COLUMN_BANK_TRANSFER_ONLINE = 'bank_transfer_online';
    const COLUMN_TOKEN_BANK_TRANSFER_NL = 'token_bank_transfer_nl';

    //status
    const NEW = 'new';
    const PENDING = 'pending';
    const SUCCESS = 'success';
    const FAIL = 'fail';

    protected $table = 'draft_nl';
}
