<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use LaravelDaily\Invoices\Classes\Buyer;
use LaravelDaily\Invoices\Classes\InvoiceItem;
use LaravelDaily\Invoices\Invoice;

class InvoiceController extends Controller
{
    public function generatePdf(Student $student)
    {
        try {

            $customer = new Buyer([
                'name' => $student->name,
                'custom_fields' => [
                    'email' => $student->email,
                    'section' => $student->section->name,
                    'class' => $student->classes->name
                ]
            ]);

            $item = InvoiceItem::make('Service 1')->pricePerUnit(503.99);

            $invoice = Invoice::make()
                ->buyer($customer)
                ->discountByPercent(10)
                ->taxRate(15)
                ->shipping(1.99)
                ->addItem($item);

            return $invoice->stream();

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
