<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CommonSupplyTransaction;
use App\Models\CommonSupplyTransactionItem;
use App\Models\Signature;
use App\Models\CenterCode;
use Barryvdh\DomPDF\Facade\Pdf;
use Dompdf\Dompdf;
use Dompdf\Options;

class RISController extends Controller
{
    // request details
    public $t_id;
    public $tcode;
    public $division;
    public $office;
    public $purpose;
    public $requester;
    public $requester_id;
    public $position_req;
    public $date_req;
    public $sign_req;
    public $approver;
    public $approver_id;
    public $position_app;
    public $date_app;
    public $sign_app;
    public $assessor;
    public $assessor_id;
    public $position_ass;
    public $date_ass;
    public $sign_ass;
    public $issuer;
    public $issuer_id;
    public $position_iss;
    public $date_iss;
    public $sign_iss;
    public $receiver;
    public $receiver_id;
    public $position_rec;
    public $date_rec;
    public $sign_rec;
    public $requested_items = [];
    public $status;
    public $risnum;
    public $entity;
    public $fund;
    public $ccode;
    public $overall_total;
    public $item_count = 0;
    public $quantity_count = 0;
    public $esig_files;

    public function view($code)
    {
        $this->esig_files = Signature::all();

        // get transaction details
        $rd = CommonSupplyTransaction::where('tcode','=',$code)->first();
        $rc = CenterCode::where('code','=',$rd->ccode)->first();
        $this->t_id = $rd->id;
        $this->tcode = $rd->tcode;
        $this->division = $rd->division;
        $this->office = $rd->office.'-'.$rc->center;
        $this->purpose = $rd->purpose;
        $this->requester_id = $rd->requester_id;
        $this->requester = $rd->requester;
        $this->position_req = $rd->position_req;
        $this->date_req = $rd->date_req;
        $this->sign_req = $rd->sign_req;
        $this->approver_id = $rd->approver_id;
        $this->approver = $rd->approver;
        $this->position_app = $rd->position_app;
        $this->date_app = $rd->date_app;
        $this->sign_app = $rd->sign_app;
        $this->assessor_id = $rd->assessor_id;
        $this->assessor = $rd->assessor;
        $this->position_ass = $rd->position_ass;
        $this->date_ass = $rd->date_ass;
        $this->sign_ass = $rd->sign_ass;
        $this->issuer_id = $rd->issuer_id;
        $this->issuer = $rd->issuer;
        $this->position_iss = $rd->position_iss;
        $this->date_iss = $rd->date_iss;
        $this->sign_iss = $rd->sign_iss;
        $this->receiver_id = $rd->receiver_id;
        $this->receiver = $rd->receiver;
        $this->position_rec = $rd->position_rec;
        $this->date_rec = $rd->date_rec;
        $this->sign_rec = $rd->sign_rec;
        $this->status = $rd->status;
        $this->risnum = $rd->risnum;
        $this->entity = $rd->entity;
        $this->fund = $rd->fund;
        $this->ccode = $rd->ccode;
        $this->overall_total = $rd->overall_total;

        // get transaction items
        $rdis = CommonSupplyTransactionItem::where('transaction_id','=',$this->t_id)
        ->join('common_supplies','common_supply_transaction_items.cs_id','=','common_supplies.id')
        ->join('units','common_supplies.unit','=','units.id')
        ->select(
            'common_supply_transaction_items.id as rdi_id',
            'common_supply_transaction_items.cs_id as rdi_cs_id',
            'common_supply_transaction_items.itemnum as rdi_no',
            'common_supplies.item as rdi_item',
            'common_supplies.description as rdi_desc',
            'common_supplies.code as rdi_code',
            'common_supply_transaction_items.quantity_req as rdi_qty_req',
            'units.unit as rdi_unit',
            'common_supply_transaction_items.available as rdi_avail',
            'common_supply_transaction_items.quantity_iss as rdi_qty_iss',
            'common_supply_transaction_items.price as rdi_price',
            'common_supply_transaction_items.total as rdi_total',
            'common_supply_transaction_items.remarks as rdi_remarks'
            )
        ->get();

        // get all distinct item numbers and get the actual items only
        $this->item_count = CommonSupplyTransactionItem::where('transaction_id','=',$this->t_id)->distinct()->count('itemnum');

        foreach ($rdis as $rdi)
        {
            $this->requested_items[] = [
                'id' => $rdi->rdi_id,
                'num' => $rdi->rdi_no,
                'code' => $rdi->rdi_code,
                'item' => $rdi->rdi_item,
                'description' => $rdi->rdi_desc,
                'unit' => $rdi->rdi_unit,
                'qty' => $rdi->rdi_qty_req,
                'avail' => $rdi->rdi_avail,
                'qtyi' => $rdi->rdi_qty_iss,
                'price' => $rdi->rdi_price,
                'total' => $rdi->rdi_total,
                'remarks' => $rdi->rdi_remarks
            ];

            $cur = '';
            if($rdi->rdi_no != $cur) // compare current item number to saved item number
            {
                $this->quantity_count += $rdi->rdi_qty_iss; // quantity count gets the actual only
                $cur = $rdi->rdi_no; // store current item number for checking
            }
        }

        $data = [
            'entity' => $this->entity,
            'fund' => $this->fund,
            'division' => $this->division,
            'ccode' => $this->ccode,
            'office' => $this->office,
            'risnum' => $this->risnum,
            'requested_items' => $this->requested_items,
            'item_count' => $this->item_count,
            'overall_total' => $this->overall_total,
            'purpose' => $this->purpose,
            'esig_files' => $this->esig_files,
            'requester_id' => $this->requester_id,
            'approver_id' => $this->approver_id,
            'issuer_id' => $this->issuer_id,
            'receiver_id' => $this->receiver_id,
            'requester' => $this->requester,
            'approver' => $this->approver,
            'issuer' => $this->issuer,
            'receiver' => $this->receiver,
            'position_req' => $this->position_req,
            'position_app' => $this->position_app,
            'position_iss' => $this->position_iss,
            'position_rec' => $this->position_rec,
            'sign_req' => $this->sign_req,
            'sign_app' => $this->sign_app,
            'sign_iss' => $this->sign_iss,
            'sign_rec' => $this->sign_rec,
            'date_req' => $this->date_req,
            'date_app' => $this->date_app,
            'date_iss' => $this->date_iss,
            'date_rec' => $this->date_rec,
        ];

        $pdf = Pdf::loadView('pdf.ris',$data);
        return $pdf->stream('RIS '.$this->risnum.'.pdf');

        // $options = new Options();
        // $options->set('defaultFont', 'DejaVu Sans');

        // $dompdf = new Dompdf($options);
        // $dompdf->loadHtml(view('pdf.ris', $data)->render());
        // $dompdf->setPaper('A4', 'portrait');
        // $dompdf->render();

        // return $dompdf->stream('ris.pdf', ['Attachment' => false]);
    }
}
