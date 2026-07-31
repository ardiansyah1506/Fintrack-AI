<?php
namespace App\Intents\Bills;
use App\Intents\Contracts\IntentInterface;
use App\Services\RecurringBillService;
class CreateBillIntent implements IntentInterface {
    public function __construct(protected RecurringBillService $service) {}
    public function handle(array $params): array {
        if (isset($params['auto_create_transaction']) && $params['auto_create_transaction'] === 'true') $params['auto_create_transaction'] = true;
        if (isset($params['auto_create_transaction']) && $params['auto_create_transaction'] === 'false') $params['auto_create_transaction'] = false;
        $res = $this->service->create($params);
        return ['intent' => 'create_bill', 'status' => 'success', 'message' => 'Tagihan rutin berhasil dibuat', 'bill' => $res];
    }
}