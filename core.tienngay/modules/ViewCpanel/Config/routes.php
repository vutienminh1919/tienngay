<?php

return [
    'paymentgateway' => [
    	'momo' => [
    		'listTransactionByMonth' 	=> config('domains.paymentgateway') . 'momo/listTransactionByMonth',
    		'searchTransactions'		=> config('domains.paymentgateway') . 'momo/searchTransactions',
            'autoConfirm'               => config('domains.paymentgateway') . 'momo/autoConfirm',
    	],
        'reconciliation' => [
            'create'                    => config('domains.paymentgateway') . 'momo/reconciliation/create',
            'getListByMonth'            => config('domains.paymentgateway') . 'momo/reconciliation/getListByMonth',
            'sendEmail'                 => config('domains.paymentgateway') . 'momo/reconciliation/sendEmail',
            'delete'                    => config('domains.paymentgateway') . 'momo/reconciliation/delete',
        ],
    ],

    'vpbank' => [
        'transaction' => [
            'getListByMonth'            => config('domains.vpbank') . 'transaction/getListByMonth',
            'searchTransactions'        => config('domains.vpbank') . 'transaction/searchTransactions',
        ],
        'mistakentransaction' => [
            'getListByMonth'            => config('domains.vpbank') . 'mistakentransaction/getListByMonth',
            'searchTransactions'        => config('domains.vpbank') . 'mistakentransaction/searchTransactions',
        ],
    ],

    'reportForm3' => [
        'search'                        => config('domains.report') . 'reportForm3/search',
        'importDungTinhLai'             => config('domains.report') . 'reportForm3/importDungTinhLai',
    ],
    'reportForm23' => [
        'search'                        => config('domains.report') . 'reportForm23/search',
    ],
    'reportForm2' => [
        'search'                        => config('domains.report') . 'reportForm2/search'
    ],
    'logTran' => [
        'search'                        => config('domains.report') . 'logTran/search'
    ],

    'api' => [
        'exportAllLead'                 => config('domains.api') . 'lead_custom/get_all_lead_export',
        'exportGicPlt'                  => config('domains.api') . 'gic_plt/get_all',
        'exportGic'                     => config('domains.api') . 'gic/get_all',
        'exportGicEasy'                 => config('domains.api') . 'gic_easy/get_all',
        'exportMicTnds'                 => config('domains.api') . 'mic_tnds/get_list_mic_tnds',
        'exportMic'                     => config('domains.api') . 'mic/get_all',
        'exportContractTnds'            => config('domains.api') . 'baoHiemTNDS/get_list_tnds',
        'exportVbiSxh'                  => config('domains.api') . 'vbi/get_all_sxh',
        'exportVbiUtv'                  => config('domains.api') . 'vbi/get_all_utv',
        'exportVbiSxhBn'                => config('domains.api') . 'vbi_sxh/get_list_vbi_sxh',
        'exportVbiUtvBn'                => config('domains.api') . 'vbi_utv/get_list_vbi_utv',
        'exportVbiTnds'                 => config('domains.api') . 'vbi_tnds/get_list_vbi_tnds'
    ],
    'ksnb' => [
        'reportksnb' => [
            'getCodeByType'             => config('domains.reportsksnb') . 'getCodeByType',
            'getPunishmentByCode'       => config('domains.reportsksnb') .'getPunishmentByCode',
            'getDisciplineByCode'       => config('domains.reportsksnb') . 'getDisciplineByCode',

            'getDescription'            => config('domains.reportsksnb') . 'getDescription',
            'saveReport'              => config('domains.reportsksnb') . 'saveReport',

            'updateReport'              => config('domains.reportsksnb') . 'updateReport',
            'updateProcess'             => config('domains.reportsksnb') . 'updateProcess',
            'updateEmailNotConfrim'     => config('domains.reportsksnb') . 'updateEmailNotConfrim',
            'updateEmailReConfrim'      => config('domains.reportsksnb') . 'updateEmailReConfrim',
            'updateInfer'               => config('domains.reportsksnb') . 'updateInfer',
            'sendfeedback'              => config('domains.reportsksnb') . 'sendfeedback',
            'getEmailCHT'               => config('domains.reportsksnb') . 'getEmailCHT',
            'getNameByEmail'            => config('domains.reportsksnb') . 'getNameByEmail',
            'updateWaitConfrim'         => config('domains.reportsksnb') . 'updateEmailWaitConfrim',
            'ksnbFeedback'              => config('domains.reportsksnb') . 'ksnbFeedback',
            'waitInfer'                 => config('domains.reportsksnb') . 'waitInfer',

            'getEmailCHTByStoreId'      => config('domains.reportsksnb') . 'getEmailCHTByStoreId',
            'getEmployeesByStoreId'     => config('domains.reportsksnb') . 'getEmployeesByStoreId',

            'allMailRoll'               => config('domains.reportsksnb') . 'allMailRoll',
            'getAllRoom'                => config('domains.reportsksnb') . 'getAllRoom',

            'getErrorCodeInfo'          => config('domains.reportsksnb') . 'getErrorCodeInfo',
            'cancelRpNv'                => config('domains.reportsksnb') . 'cancelRpNv',
            'cancelRpTbp'               => config('domains.reportsksnb') . 'cancelRpTbp',
            'endTimeReport'             => config('domains.reportsksnb') . 'endTimeReport',
            'getEMailEndTime'           => config('domains.reportsksnb') . 'getEMailEndTime',
            'getQuoteDocument'          => config('domains.reportsksnb') . 'getQuoteDocument',
            'saveNote'                  => config('domains.reportsksnb') . 'saveNote',
            'getUserActive'             => config('domains.reportsksnb') . 'getUserActive',
            'updateNote'                => config('domains.reportsksnb') . 'updateNote',
            'waitConfirmNote'           => config('domains.reportsksnb') . 'waitConfirmNote',
            'notConfirmNote'            => config('domains.reportsksnb') . 'notConfirmNote',
            'reConfirmNote'             => config('domains.reportsksnb') . 'reConfirmNote',
            'confirmNote'               => config('domains.reportsksnb') . 'confirmNote',
            'userFeedback'              => config('domains.reportsksnb') . 'userFeedback',
            'ksnbFeedbackReport'        => config('domains.reportsksnb') . 'ksnbFeedbackReport',
            'waitInferNote'             => config('domains.reportsksnb') . 'waitInferNote',
            'inferNote'                 => config('domains.reportsksnb') . 'inferNote',
            'sendCeo'                   => config('domains.reportsksnb') . 'sendCeo',
            'ceoNotConfirm'             => config('domains.reportsksnb') . 'ceoNotConfirm',
            'ceoConfirm'                => config('domains.reportsksnb') . 'ceoConfirm',
        ]
    ],

    'pti' => [
        'bhtn' => [
            'apiGetPdfFile'            => config('domains.pti') . 'bhtn/apiGetPdfFile',
            'orderBhtnBN'              => config('domains.pti') . 'bhtn/orderBhtnBN',
        ],
    ],

    'hcns' => [
        'black_list' => [
            'saveRecord'                => config('domains.hcns') . 'saveRecord',
            'updateRecord'              => config('domains.hcns') . 'updateRecord',
            'getAllHcns'                => config('domains.hcns') . 'getAllHcns',
        ]
    ],

    'tool' => [
        'sendEmail' => [
            'email'                             => config('domains.toolSendEmail') . 'toolSendEmail',
            'saveTemplate'                      => config('domains.toolSendEmail') . 'saveTemplate',
            'getCodeEmail'                      => config('domains.toolSendEmail') . 'getCodeEmail',
            'getSubject'                        => config('domains.toolSendEmail') . 'getSubject',
            'updateTemplate'                    => config('domains.toolSendEmail') . 'updateTemplate',
            'getUserMkt'                        => config('domains.toolSendEmail') . 'getUserMkt',
            'getSlug'                           => config('domains.toolSendEmail') . 'getSlug',
        ]
    ],

    'heyu' => [
        'store'                                 => config('domains.heyu') . 'insertStoreTienngay',
        'getAllUniform'                         => config('domains.heyu') . 'getAllUniform',
        'getStatus'                             => config('domains.heyu') . 'getStatus',
        'inventory'                             => config('domains.heyu') . 'inventory',
        'update'                                => config('domains.heyu') . 'updateOrInsertStoreTienngay',
        'findUserByCode'                        => config('domains.heyu') . 'findUserByCode',
        'handover'                              => [
            'store'                                 => config('domains.heyu') . 'handover/store',
            'approve'                               => config('domains.heyu') . 'handover/approve',
            'cancel'                               => config('domains.heyu') . 'handover/cancel',
        ],
        'store' => [
            'getAllUniform'                     => config('domains.heyu') . 'getAllUniform',
            'getStatus'                         => config('domains.heyu') . 'getStatus',
            'inventory'                         => config('domains.heyu') . 'inventory',
            'update'                            => config('domains.heyu') . 'updateOrInsertStoreTienngay',
            'findUserByCode'                    => config('domains.heyu') . 'findUserByCode',
            'edit'                              => config('domains.heyu') . 'editStoreTienngay',
        ]
    ],

    'trade' => [
        'item' => [
            'insert'                            => config('domains.trade') . 'insert',
            'getTypeByName'                     => config('domains.trade') . 'getTypeByName',
            'blockItem'                         => config('domains.trade') . 'blockItem',
            'detailItem'                        => config('domains.trade') . 'detailItem',
            'update'                            => config('domains.trade') . 'update',
            'getItemsByStoreId'                 => config('domains.trade') . 'getItemsByStoreId',
            'getItemByItemId'                   => config('domains.trade') . 'getItemByItemId',
        ],
        'inventory' => [
            'adjustmentInsert'                  => config('domains.trade') . 'inventory/adjustmentInsert',
            'reportCreate'                      => config('domains.trade') . 'inventory/reportCreate',
            'getItemByStoreId'                  => config('domains.trade') . 'inventory/getItemByStoreId',
            'updateAdjustmentDone'              => config('domains.trade') . 'inventory/updateAdjustmentDone',
            'updateAdjustmentCancel'            => config('domains.trade') . 'inventory/updateAdjustmentCancel',
            'getAreaByDomain'                   => config('domains.trade') . 'inventory/getAreaByDomain',
            'getStoreByCodeArea'                => config('domains.trade') . 'inventory/getStoreByCodeArea',
            'insertExplanation'                => config('domains.trade') . 'inventory/insertExplanation',
        ],
        'warehouse' => [
            'pgd_save'                          => config('domains.trade') . 'warehouse/pgd_save',
            'getItem'                           => config('domains.trade') . 'warehouse/getItemByStore',
            'updateLisence'                     => config('domains.trade') . 'warehouse/updateLisence',
            'getAreaByDomain'                   => config('domains.trade') . 'warehouse/getAreaByDomain',
            'getStoreByArea'                   => config('domains.trade') . 'warehouse/getStoreByArea',
        ],
        'tradeOrder' => [
            'requestOrder'                      => config('domains.trade') . 'request-order/order',
            'updateProgress'                    => config('domains.trade') . 'request-order/update-progress',
            'updateOrder'                       => config('domains.trade') . 'request-order/updateOrder',
            'deleteOrder'                       => config('domains.trade') . 'request-order/deleteOrder',
            'confirmedAllotment'                => config('domains.trade') . 'request-order/confirmedAllotment',
        ],
        'budgetEstimates' => [
            'removeBudgetEstimate'              => config('domains.trade') . 'budget-estimates/removeBudgetEstimate',
            'addBudgetEstimate'                 => config('domains.trade') . 'budget-estimates/addBudgetEstimate',
            'updateCustomerGoal'                => config('domains.trade') . 'budget-estimates/updateCustomerGoal',
            'addComment'                        => config('domains.trade') . 'budget-estimates/addComment',
            'updateBudgetEstimateProgress'      => config('domains.trade') . 'budget-estimates/updateProgress',
            'deleteBE'                          => config('domains.trade') . 'budget-estimates/deleteBE',
        ],
        'publications' => [
            'create_publication_status1'            => config('domains.trade') . 'publications/create_publication_status1',
            'create_publication_status2'            => config('domains.trade') . 'publications/create_publication_status2',
            'find_one_trade'                        => config('domains.trade') . 'publications/find_one_trade',
            'get_all_publications'                  => config('domains.trade') . 'publications/get_all_publications',
            'find_publics'                          => config('domains.trade') . 'publications/find_publics',
            'note_one_publication'                  => config('domains.trade') . 'publications/note_one_publication',
            'note_publications'                     => config('domains.trade') . 'publications/note_publications',
            'find_publication1'                     => config('domains.trade') . 'publications/find_publication1',
            'findLog'                               => config('domains.trade') . 'publications/findLog',
            'findLog1'                              => config('domains.trade') . 'publications/findLog1',
            'acceptance_publication'                => config('domains.trade') . 'publications/acceptance_publication',
            'update_publications'                   => config('domains.trade') . 'publications/update_publications',
            'update_status_block'                   => config('domains.trade') . 'publications/update_status_block',
            'update_status_order'                   => config('domains.trade') . 'publications/update_status_order',
            'findKeyId'                             => config('domains.trade') . 'publications/findKeyId',
            'getAllTradeOder'                       => config('domains.trade') . 'publications/getAllTradeOder',
            'allotment_publication'                 => config('domains.trade') . 'publications/allotment_publication',
        ],
        'transfer' => [
            'save'                              => config('domains.trade') . 'transfer/save',
            'update'                            => config('domains.trade') . 'transfer/update',
            'cancel'                            => config('domains.trade') . 'transfer/cancel',
            'delete'                            => config('domains.trade') . 'transfer/delete',
            'confirmExport'                     => config('domains.trade') . 'transfer/confirmExport',
            'confirmImport'                     => config('domains.trade') . 'transfer/confirmImport',
            'confirmCreate'                     => config('domains.trade') . 'transfer/confirmCreate',
        ]
    ],

    'macom' => [
        'save' => config('domains.macom') . 'save',
        'getStoreByCodeArea' => config('domains.macom') . 'getStoreByCodeArea',
        'update' =>  config('domains.macom') . 'update',
        'getAreaByDomain' =>  config('domains.macom') . 'getAreaByDomain',
    ],
    'paymentHolidays' => [
        'create'                            => config('domains.paymentHolidays') . 'create',
        'update'                              => config('domains.paymentHolidays') . 'edit',
        'delete'                            => config('domains.paymentHolidays') . 'delete',
        'status'                            => config('domains.paymentHolidays') . 'status',
    ],
];
