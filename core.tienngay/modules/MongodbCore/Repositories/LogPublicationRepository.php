<?php


namespace Modules\MongodbCore\Repositories;


use Modules\MongodbCore\Entities\LogPublication;
use Modules\MongodbCore\Entities\Qlpublications;
use Modules\MongodbCore\Entities\TradeItem;

class LogPublicationRepository
{
    protected $qlpublications;
    protected $tradeItem;
    protected $logPublication;

    public function __construct(Qlpublications $qlpublications,TradeItem $tradeItem,LogPublication $logPublication)
    {
        $this->qlpublications = $qlpublications;
        $this->tradeItem = $tradeItem;
        $this->logPublication = $logPublication;
    }


}
