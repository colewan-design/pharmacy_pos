<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;

use App\{category, item, transaction, order, department, table, device, payment, User};
use DB;
use App\texttable;


use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;

use Illuminate\Support\Facades\Auth;
use \Carbon\Carbon;
session_start();

use Illuminate\Support\Arr;

class printController extends BaseController
{

    public function printKitchen($transactionId){


        $orderTransaction = [];
        $orderDetails = [];
        try {
            $device = DB::select("SELECT deviceName  FROM devices WHERE departmentId = 1");
            // Enter the share name for your printer here, as a smb:// url format
            $connector = new WindowsPrintConnector($device[0]->deviceName); // for local printer
            // $connector = new NetworkPrintConnector($device[0]->deviceName, 9100); // for network printer



            /* Print a "Hello world" receipt" */
            $printer = new Printer($connector);

            $orderInTransactions=  DB::table('transactions')
            ->leftjoin('orders', 'transactions.transactionId', '=', 'orders.transactionId')
            ->leftjoin('tables', 'tables.tableId', '=', 'transactions.transactionTableId')
            ->leftjoin('items', 'orders.itemId', '=', 'items.itemId')
            ->leftjoin('categories', 'items.categoryId', '=', 'categories.categoryId')
            ->leftjoin('departments', 'categories.departmentId', '=', 'departments.departmentId')
            ->where('departments.departmentId', '=' , '1')
            ->where('transactions.transactionStatus', '!=' , 'Available')
            ->where('transactions.transactionId', '=' , $transactionId)
            ->where('orders.orderStatus', '=' , '0')
            ->get()->toArray();


            if (empty($orderInTransactions)) {
                /* Close printer */
                $printer -> close();
            }else{

                    $orderInTransactionDetails =  DB::select('SELECT *,
                                                            (
                                                            SELECT SUM(orderPrice)
                                                            FROM orders z
                                                            LEFT JOIN categories y ON y.categoryId = z.categoryId
                                                            LEFT JOIN departments w ON y.departmentId = w.departmentId
                                                            WHERE
                                                            z.orderStatus = 0 AND w.departmentId = 1) AS total
                                                            FROM transactions a
                                                            LEFT JOIN tables c ON a.transactionTableId = c.tableId
                                                            WHERE a.transactionId ='.$transactionId.'
                                                            ' );

                    foreach ($orderInTransactionDetails as $oitd) {
                        $tableNo =  $oitd->tableNumber;
                        $transactionSlipNo =  $oitd->transactionSlipNo;
                        $header ="KITCHEN ORDER ".$tableNo."";
                        //header
                        $printer -> setTextSize(2,2);
                        $printer -> setJustification(Printer::FONT_C);
                        $printer -> setJustification(Printer::JUSTIFY_CENTER);
                        $printer -> text("".$header."\n");

                        $printer -> setTextSize(1,1);
                        $printer -> setJustification(Printer::FONT_C);
                        $printer -> setJustification(Printer::JUSTIFY_CENTER);
                        $printer -> text("TN:".$transactionSlipNo."\n");
                        $printer -> text("\n");

                    }



                    $footerSpace =  str_repeat(' ', 15);
                    foreach ($orderInTransactionDetails as $oitd) {
                        $total = $oitd->total;
                        $serveBy = $oitd->transactionServedBy;
                        $tableNo =  $oitd->tableName;
                        $transactionSlipNo =  $oitd->transactionSlipNo;

                        $printer -> setTextSize(1,1);
                        $printer -> setJustification(Printer::FONT_C);
                        $printer -> setJustification(Printer::JUSTIFY_LEFT);
                        $printer -> text("Served By:".$serveBy."\n");
                        $printer -> text("\n");

                    }

                    $four =  str_repeat(' ', 15);
                    foreach ($orderInTransactions as $oit) {
                        $qty = $oit->orderQty;
                        $itemDescription = $oit->itemName;
                        $itemPrice =  $oit->itemPrice;
                        $itemNote = $oit->itemNote;

                        $orderTransaction[] =['QTY' => $qty,
                                            'DESCRIPTION' => $itemDescription."\n"."Note:".$itemNote
                                            ];

                    }
                    $printer -> setTextSize(1,1);
                    $printer -> setJustification(Printer::JUSTIFY_LEFT);
                    $printer -> text(texttable::table($orderTransaction));
                    unset($orderTransaction);

                    foreach ($orderInTransactionDetails as $oitd) {
                        $note =  $oitd->transactionNote;
                        $printer -> setTextSize(1,1);
                        $printer -> setJustification(Printer::FONT_C);
                        $printer -> setJustification(Printer::JUSTIFY_LEFT);
                        $printer -> text("Note:".$note."\n");
                    }

                    //Footer
                    $date = date("Y-m-d H:i:s");
                    $printer -> setTextSize(1,1);
                    $printer -> setJustification(Printer::FONT_C);
                    $printer -> setJustification(Printer::JUSTIFY_CENTER);
                    $printer -> text("Date:".$date."\n");


                    $printer -> cut();

                    //another Print

                    foreach ($orderInTransactionDetails as $oitd) {
                        $tableNo =  $oitd->tableNumber;
                        $transactionSlipNo =  $oitd->transactionSlipNo;
                        $header ="KITCHEN ORDER ".$tableNo."";
                        //header
                        $printer -> setTextSize(2,2);
                        $printer -> setJustification(Printer::FONT_C);
                        $printer -> setJustification(Printer::JUSTIFY_CENTER);
                        $printer -> text("".$header."\n");

                        $printer -> setTextSize(1,1);
                        $printer -> setJustification(Printer::FONT_C);
                        $printer -> setJustification(Printer::JUSTIFY_CENTER);
                        $printer -> text("TN:".$transactionSlipNo."\n");
                        $printer -> text("\n");

                    }



                    $footerSpace =  str_repeat(' ', 15);
                    foreach ($orderInTransactionDetails as $oitd) {
                        $total = $oitd->total;
                        $serveBy = $oitd->transactionServedBy;
                        $tableNo =  $oitd->tableName;
                        $transactionSlipNo =  $oitd->transactionSlipNo;

                        $printer -> setTextSize(1,1);
                        $printer -> setJustification(Printer::FONT_C);
                        $printer -> setJustification(Printer::JUSTIFY_LEFT);
                        $printer -> text("Served By:".$serveBy."\n");
                        $printer -> text("\n");

                    }

                    $four =  str_repeat(' ', 15);
                    foreach ($orderInTransactions as $oit) {
                        $qty = $oit->orderQty;
                        $itemDescription = $oit->itemName;
                        $itemPrice =  $oit->itemPrice;
                        $itemNote = $oit->itemNote;

                        $orderTransaction[] =['QTY' => $qty,
                                            'DESCRIPTION' => $itemDescription."\n"."Note:".$itemNote
                                            ];

                    }
                    $printer -> setTextSize(1,1);
                    $printer -> setJustification(Printer::JUSTIFY_LEFT);
                    $printer -> text(texttable::table($orderTransaction));
                    unset($orderTransaction);

                    foreach ($orderInTransactionDetails as $oitd) {
                        $note =  $oitd->transactionNote;
                        $printer -> setTextSize(1,1);
                        $printer -> setJustification(Printer::FONT_C);
                        $printer -> setJustification(Printer::JUSTIFY_LEFT);
                        $printer -> text("Note:".$note."\n");
                    }

                    //Footer
                    $date = date("Y-m-d H:i:s");
                    $printer -> setTextSize(1,1);
                    $printer -> setJustification(Printer::FONT_C);
                    $printer -> setJustification(Printer::JUSTIFY_CENTER);
                    $printer -> text("Date:".$date."\n");

                    $printer -> cut();

                    /* Close printer */
                    $printer -> close();
                    return true;
            }
        } catch (ErrorException | HandleExceptions $print_exception) {
            $device = DB::select("SELECT deviceName  FROM devices WHERE departmentId = 2");
            $connector = new WindowsPrintConnector($device[0]->deviceName);
            $printer = new Printer($connector);
            $printer -> close();
            return response('200', 'Printer not found');
        } catch (Exception $e) {
            return response('500', $e->getMessage());
        }
        return true;
    }

    public function printBar($transactionId){
        $orderTransaction = [];
        $orderDetails = [];
        try {
            $device = DB::select("SELECT deviceName  FROM devices WHERE departmentId = 2");
            // Enter the share name for your printer here, as a smb:// url format
            $connector = new WindowsPrintConnector($device[0]->deviceName);
            //$connector = new WindowsPrintConnector("smb://Guest@computername/Receipt Printer");
            //$connector = new WindowsPrintConnector("smb://FooUser:secret@computername/workgroup/Receipt Printer");
            //$connector = new WindowsPrintConnector("smb://User:secret@computername/Receipt Printer");

            /* Print a "Hello world" receipt" */
            $printer = new Printer($connector);
            $orderInTransactions=  DB::table('transactions')
            ->leftjoin('orders', 'transactions.transactionId', '=', 'orders.transactionId')
            ->leftjoin('tables', 'tables.tableId', '=', 'transactions.transactionTableId')
            ->leftjoin('items', 'orders.itemId', '=', 'items.itemId')
            ->leftjoin('categories', 'items.categoryId', '=', 'categories.categoryId')
            ->leftjoin('departments', 'categories.departmentId', '=', 'departments.departmentId')
            ->where('departments.departmentId', '=' , '2')
            ->where('transactions.transactionStatus', '!=' , 'Available')
            ->where('transactions.transactionId', '=' , $transactionId)
            ->where('orders.orderStatus', '=' , '0')
            ->get()->toArray();


            if (empty($orderInTransactions)) {
                /* Close printer */
                $printer -> close();
            }else{

                    $orderInTransactionDetails =  DB::select('SELECT *,
                                                                (
                                                                SELECT SUM(orderPrice)
                                                                FROM orders z
                                                                LEFT JOIN categories y ON y.categoryId = z.categoryId
                                                                LEFT JOIN departments w ON y.departmentId = w.departmentId
                                                                WHERE
                                                                z.orderStatus = 0 AND w.departmentId = 2) AS total
                                                                FROM transactions a
                                                                LEFT JOIN tables c ON a.transactionTableId = c.tableId
                                                                WHERE a.transactionId ='.$transactionId.'
                                                                ' );

                    foreach ($orderInTransactionDetails as $oitd) {
                        $tableNo =  $oitd->tableNumber;
                        $transactionSlipNo =  $oitd->transactionSlipNo;
                        $header ="BAR ORDER ".$tableNo."";
                        //header
                        $printer -> setTextSize(2,2);
                        $printer -> setJustification(Printer::FONT_C);
                        $printer -> setJustification(Printer::JUSTIFY_CENTER);
                        $printer -> text("".$header."\n");

                        $printer -> setTextSize(1,1);
                        $printer -> setJustification(Printer::FONT_C);
                        $printer -> setJustification(Printer::JUSTIFY_CENTER);
                        $printer -> text("TN:".$transactionSlipNo."\n");
                        $printer -> text("\n");

                    }



                    $footerSpace =  str_repeat(' ', 15);
                    foreach ($orderInTransactionDetails as $oitd) {
                        $total = $oitd->total;
                        $serveBy = $oitd->transactionServedBy;
                        $tableNo =  $oitd->tableName;
                        $transactionSlipNo =  $oitd->transactionSlipNo;

                        $printer -> setTextSize(1,1);
                        $printer -> setJustification(Printer::FONT_C);
                        $printer -> setJustification(Printer::JUSTIFY_LEFT);
                        $printer -> text("Served By:".$serveBy."\n");
                        $printer -> text("\n");

                    }

                    $four =  str_repeat(' ', 4);
                    foreach ($orderInTransactions as $oit) {
                        $qty = $oit->orderQty;
                        $itemDescription = wordwrap($oit->itemName, 13, "\n".$four, false);
                        $itemPrice =  $oit->itemPrice;
                        $itemNote = $oit->itemNote;

                        $orderTransaction[] =['QTY' => $qty,
                                            'DESCRIPTION' => $itemDescription."\n"."Note:".$itemNote
                                            ];

                    }
                    $printer -> setTextSize(2,2);
                    $printer -> setJustification(Printer::JUSTIFY_LEFT);
                    $printer -> text(texttable::table($orderTransaction));
                    unset($orderTransaction);

                    foreach ($orderInTransactionDetails as $oitd) {
                        $note =  $oitd->transactionNote;
                        $printer -> setTextSize(2,2);
                        $printer -> setJustification(Printer::FONT_C);
                        $printer -> setJustification(Printer::JUSTIFY_LEFT);
                        $printer -> text("Note:".$note."\n");
                    }

                    //Footer
                    $date = date("Y-m-d H:i:s");
                    $printer -> setTextSize(1,1);
                    $printer -> setJustification(Printer::FONT_C);
                    $printer -> setJustification(Printer::JUSTIFY_CENTER);
                    $printer -> text("Date:".$date."\n");



                    $printer -> cut();

                    /* Close printer */
                    $printer -> close();
                    return true;
            }
        } catch (ErrorException | HandleExceptions $print_exception) {
            $device = DB::select("SELECT deviceName  FROM devices WHERE departmentId = 2");
            $connector = new WindowsPrintConnector($device[0]->deviceName);
            $printer = new Printer($connector);
            $printer -> close();
            return response('200', 'Printer not found');
        } catch (Exception $e) {
            return response('500', 'An error occurred');
        }

        return true;
    }

    public function printOutsourced($transactionId){


        $orderTransaction = [];
        $orderDetails = [];
        try {
            $device = DB::select("SELECT deviceName  FROM devices WHERE departmentId = 4");
            // Enter the share name for your printer here, as a smb:// url format
            $connector = new WindowsPrintConnector($device[0]->deviceName);
            //$connector = new WindowsPrintConnector("smb://Guest@computername/Receipt Printer");
            //$connector = new WindowsPrintConnector("smb://FooUser:secret@computername/workgroup/Receipt Printer");
            //$connector = new WindowsPrintConnector("smb://User:secret@computername/Receipt Printer");



            /* Print a "Hello world" receipt" */
            $printer = new Printer($connector);

            $orderInTransactions=  DB::table('transactions')
            ->leftjoin('orders', 'transactions.transactionId', '=', 'orders.transactionId')
            ->leftjoin('tables', 'tables.tableId', '=', 'transactions.transactionTableId')
            ->leftjoin('items', 'orders.itemId', '=', 'items.itemId')
            ->leftjoin('categories', 'items.categoryId', '=', 'categories.categoryId')
            ->leftjoin('departments', 'categories.departmentId', '=', 'departments.departmentId')
            ->where('departments.departmentId', '=' , '4')
            ->where('transactions.transactionStatus', '!=' , 'Available')
            ->where('transactions.transactionId', '=' , $transactionId)
            ->where('orders.orderStatus', '=' , '0')
            ->get()->toArray();

            if (empty($orderInTransactions)) {
                /* Close printer */
                $printer -> close();
            }else{


                $orderInTransactionDetails =  DB::select('SELECT *,
                                                        (
                                                        SELECT SUM(orderPrice)
                                                        FROM orders z
                                                        LEFT JOIN categories y ON y.categoryId = z.categoryId
                                                        LEFT JOIN departments w ON y.departmentId = w.departmentId
                                                        WHERE
                                                        z.orderStatus = 0 AND w.departmentId = 4) AS total
                                                        FROM transactions a
                                                        LEFT JOIN tables c ON a.transactionTableId = c.tableId
                                                        WHERE a.transactionId ='.$transactionId.'
                                                        ' );

                foreach ($orderInTransactionDetails as $oitd) {
                    $tableNo =  $oitd->tableNumber;
                    $transactionSlipNo =  $oitd->transactionSlipNo;
                    $header ="OUTSOURCED ORDER ".$tableNo."";
                    //header
                    $printer -> setTextSize(2,2);
                    $printer -> setJustification(Printer::FONT_C);
                    $printer -> setJustification(Printer::JUSTIFY_CENTER);
                    $printer -> text("".$header."\n");

                    $printer -> setTextSize(1,1);
                    $printer -> setJustification(Printer::FONT_C);
                    $printer -> setJustification(Printer::JUSTIFY_CENTER);
                    $printer -> text("TN:".$transactionSlipNo."\n");
                    $printer -> text("\n");

                }



                $footerSpace =  str_repeat(' ', 15);
                foreach ($orderInTransactionDetails as $oitd) {
                    $total = $oitd->total;
                    $serveBy = $oitd->transactionServedBy;
                    $tableNo =  $oitd->tableName;
                    $transactionSlipNo =  $oitd->transactionSlipNo;

                    $printer -> setTextSize(1,1);
                    $printer -> setJustification(Printer::FONT_C);
                    $printer -> setJustification(Printer::JUSTIFY_LEFT);
                    $printer -> text("Served By:".$serveBy."\n");
                    $printer -> text("\n");

                }

                $four =  str_repeat(' ', 4);
                foreach ($orderInTransactions as $oit) {
                    $qty = $oit->orderQty;
                    $itemDescription = wordwrap($oit->itemName, 13, "\n".$four, false);
                    $itemPrice =  $oit->itemPrice;
                    $itemNote =  $oit->itemNote;

                    $orderTransaction[] =['QTY' => $qty,
                                        'DESCRIPTION' => $itemDescription."\n"."Note:".$itemNote
                                        ];

                }

                $printer -> setTextSize(2,2);
                $printer -> setJustification(Printer::JUSTIFY_LEFT);
                $printer -> text(texttable::table($orderTransaction));
                unset($orderTransaction);

                foreach ($orderInTransactionDetails as $oitd) {
                    $note =  $oitd->transactionNote;
                    $printer -> setTextSize(2,2);
                    $printer -> setJustification(Printer::FONT_C);
                    $printer -> setJustification(Printer::JUSTIFY_LEFT);
                    $printer -> text("Note:".$note."\n");
                }

                //Footer
                $date = date("Y-m-d H:i:s");
                $printer -> setTextSize(1,1);
                $printer -> setJustification(Printer::FONT_C);
                $printer -> setJustification(Printer::JUSTIFY_CENTER);
                $printer -> text("Date:".$date."\n");



                $printer -> cut();

                /* Close printer */
                $printer -> close();
            }
        } catch (Exception $e) {
        }

    }


    public function printClickKitchen($transactionId){



            $orderTransaction = [];
            $orderDetails = [];
            try {
                $device = DB::select("SELECT deviceName  FROM devices WHERE departmentId = 1");

                // Enter the share name for your printer here, as a smb:// url format
                // $connector = new NetworkPrintConnector($device[0]->deviceName, 9100);  // 9100 - [network] printer port
                $connector = new WindowsPrintConnector($device[0]->deviceName); // to use smb://

                /* Print a "Hello world" receipt" */
                $printer = new Printer($connector);

                $orderInTransactions=  DB::table('transactions')
                ->leftjoin('orders', 'transactions.transactionId', '=', 'orders.transactionId')
                ->leftjoin('tables', 'tables.tableId', '=', 'transactions.transactionTableId')
                ->leftjoin('items', 'orders.itemId', '=', 'items.itemId')
                ->leftjoin('categories', 'items.categoryId', '=', 'categories.categoryId')
                ->leftjoin('departments', 'categories.departmentId', '=', 'departments.departmentId')
                ->where('departments.departmentId', '=' , '1')
                ->where('transactions.transactionStatus', '!=' , 'Available')
                ->where('orders.transactionId', '=' , $transactionId)
                ->where('orders.orderStatus', '=' , '0')
                ->get()->toArray();


                $orderInTransactionDetails =  DB::select('SELECT *,
                                                        (
                                                        SELECT SUM(orderPrice)
                                                        FROM orders z
                                                        LEFT JOIN categories y ON y.categoryId = z.categoryId
                                                        LEFT JOIN departments w ON y.departmentId = w.departmentId
                                                        WHERE
                                                        w.departmentId = 1) AS total
                                                        FROM transactions a
                                                        LEFT JOIN tables c ON a.transactionTableId = c.tableId
                                                        WHERE a.transactionId ='.$transactionId.'
                                                        ' );

                foreach ($orderInTransactionDetails as $oitd) {
                    $tableNo =  $oitd->tableNumber;
                    $transactionSlipNo =  $oitd->transactionSlipNo;
                    $header ="KITCHEN ORDER ".$tableNo."";
                    //header
                    $printer -> setTextSize(2,2);
                    $printer -> setJustification(Printer::FONT_C);
                    $printer -> setJustification(Printer::JUSTIFY_CENTER);
                    $printer -> text("".$header."\n");

                    $printer -> setTextSize(1,1);
                    $printer -> setJustification(Printer::FONT_C);
                    $printer -> setJustification(Printer::JUSTIFY_CENTER);
                    $printer -> text("TN:".$transactionSlipNo."\n");
                    $printer -> text("\n");

                }



                $footerSpace =  str_repeat(' ', 15);
                foreach ($orderInTransactionDetails as $oitd) {
                    $total = $oitd->total;
                    $serveBy = $oitd->transactionServedBy;
                    $tableNo =  $oitd->tableName;
                    $transactionSlipNo =  $oitd->transactionSlipNo;

                    $printer -> setTextSize(1,1);
                    $printer -> setJustification(Printer::FONT_C);
                    $printer -> setJustification(Printer::JUSTIFY_LEFT);
                    $printer -> text("Served By:".$serveBy."\n");
                    $printer -> text("\n");

                }

                $four =  str_repeat(' ', 4);
                foreach ($orderInTransactions as $oit) {
                    $qty = $oit->orderQty;
                    $itemDescription = $oit->itemName;
                    $itemPrice =  $oit->itemPrice;
                    $itemNote = $oit->itemNote;

                    $orderTransaction[] =['QTY' => $qty,
                                        'DESCRIPTION' => $itemDescription."\n"."Note:".$itemNote
                                         ];

                }
                $printer -> setTextSize(1,1);
                $printer -> setJustification(Printer::JUSTIFY_LEFT);
                $printer -> text(texttable::table($orderTransaction));


                foreach ($orderInTransactionDetails as $oitd) {
                    $note =  $oitd->transactionNote;
                    $printer -> setTextSize(1,1);
                    $printer -> setJustification(Printer::FONT_C);
                    $printer -> setJustification(Printer::JUSTIFY_LEFT);
                    $printer -> text("Note:".$note."\n");
                }

                //Footer
                $date = date("Y-m-d H:i:s");
                $printer -> setTextSize(1,1);
                $printer -> setJustification(Printer::FONT_C);
                $printer -> setJustification(Printer::JUSTIFY_CENTER);
                $printer -> text("Date:".$date."\n");



                $printer -> cut();

                //another Print

            foreach ($orderInTransactionDetails as $oitd) {
                $tableNo =  $oitd->tableNumber;
                $transactionSlipNo =  $oitd->transactionSlipNo;
                $header ="KITCHEN ORDER ".$tableNo."";
                //header
                $printer -> setTextSize(2,2);
                $printer -> setJustification(Printer::FONT_C);
                $printer -> setJustification(Printer::JUSTIFY_CENTER);
                $printer -> text("".$header."\n");

                $printer -> setTextSize(1,1);
                $printer -> setJustification(Printer::FONT_C);
                $printer -> setJustification(Printer::JUSTIFY_CENTER);
                $printer -> text("TN:".$transactionSlipNo."\n");
                $printer -> text("\n");

            }



            $footerSpace =  str_repeat(' ', 15);
            foreach ($orderInTransactionDetails as $oitd) {
                $total = $oitd->total;
                $serveBy = $oitd->transactionServedBy;
                $tableNo =  $oitd->tableName;
                $transactionSlipNo =  $oitd->transactionSlipNo;

                $printer -> setTextSize(1,1);
                $printer -> setJustification(Printer::FONT_C);
                $printer -> setJustification(Printer::JUSTIFY_LEFT);
                $printer -> text("Served By:".$serveBy."\n");
                $printer -> text("\n");

            }

            $four =  str_repeat(' ', 15);
            foreach ($orderInTransactions as $oit) {
                $qty = $oit->orderQty;
                $itemDescription = $oit->itemName;
                $itemPrice =  $oit->itemPrice;

                $orderTransaction[] =['QTY' => $qty,
                                    'DESCRIPTION' => $itemDescription
                                     ];

            }
            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $printer -> text(texttable::table($orderTransaction));
            unset($orderTransaction);

            foreach ($orderInTransactionDetails as $oitd) {
                $note =  $oitd->transactionNote;
                $printer -> setTextSize(1,1);
                $printer -> setJustification(Printer::FONT_C);
                $printer -> setJustification(Printer::JUSTIFY_LEFT);
                $printer -> text("Note:".$note."\n");
            }

            //Footer
            $date = date("Y-m-d H:i:s");
            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_C);
            $printer -> setJustification(Printer::JUSTIFY_CENTER);
            $printer -> text("Date:".$date."\n");

            $printer -> cut();

                /* Close printer */
                $printer -> close();
            } catch (Exception $e) {
            }



    }

    public function printClickBar($transactionId){
        $orderTransaction = [];
        $orderDetails = [];
        try {
            $device =DB::select("SELECT deviceName  FROM devices WHERE departmentId = 2");
            // Enter the share name for your printer here, as a smb:// url format
            $connector = new WindowsPrintConnector($device[0]->deviceName);
            // $connector = new WindowsPrintConnector("smb://DESKTOP-EN0ACJM/EPSON TM-T82X");
            //$connector = new WindowsPrintConnector("smb://FooUser:secret@computername/workgroup/Receipt Printer");
            //$connector = new WindowsPrintConnector("smb://User:secret@computername/Receipt Printer");



            /* Print a "Hello world" receipt" */
            $printer = new Printer($connector);

            $orderInTransactions=  DB::table('transactions')
            ->leftjoin('orders', 'transactions.transactionId', '=', 'orders.transactionId')
            ->leftjoin('tables', 'tables.tableId', '=', 'transactions.transactionTableId')
            ->leftjoin('items', 'orders.itemId', '=', 'items.itemId')
            ->leftjoin('categories', 'items.categoryId', '=', 'categories.categoryId')
            ->leftjoin('departments', 'categories.departmentId', '=', 'departments.departmentId')
            ->where('departments.departmentId', '=' , '2')
            ->where('transactions.transactionStatus', '!=' , 'Available')
            ->where('orders.transactionId', '=' , $transactionId)
            ->where('orders.orderStatus', '=' , '0')
            ->get()->toArray();

            $orderInTransactionDetails =  DB::select('SELECT *,
                                                        (
                                                        SELECT SUM(orderPrice)
                                                        FROM orders z
                                                        LEFT JOIN categories y ON y.categoryId = z.categoryId
                                                        LEFT JOIN departments w ON y.departmentId = w.departmentId
                                                        WHERE
                                                        w.departmentId = 2) AS total
                                                        FROM transactions a
                                                        LEFT JOIN tables c ON a.transactionTableId = c.tableId
                                                        WHERE a.transactionId ='.$transactionId.'
                                                        ' );

            foreach ($orderInTransactionDetails as $oitd) {
                $tableNo =  $oitd->tableNumber;
                $transactionSlipNo =  $oitd->transactionSlipNo;
                $header ="BAR ORDER ".$tableNo."";
                //header
                $printer -> setTextSize(2,2);
                $printer -> setJustification(Printer::FONT_C);
                $printer -> setJustification(Printer::JUSTIFY_CENTER);
                $printer -> text("".$header."\n");

                $printer -> setTextSize(1,1);
                $printer -> setJustification(Printer::FONT_C);
                $printer -> setJustification(Printer::JUSTIFY_CENTER);
                $printer -> text("TN:".$transactionSlipNo."\n");
                $printer -> text("\n");

            }

            $footerSpace =  str_repeat(' ', 15);
            foreach ($orderInTransactionDetails as $oitd) {
                $total = $oitd->total;
                $serveBy = $oitd->transactionServedBy;
                $tableNo =  $oitd->tableName;
                $transactionSlipNo =  $oitd->transactionSlipNo;

                $printer -> setTextSize(1,1);
                $printer -> setJustification(Printer::FONT_C);
                $printer -> setJustification(Printer::JUSTIFY_LEFT);
                $printer -> text("Served By:".$serveBy."\n");
                $printer -> text("\n");

            }

            $four =  str_repeat(' ', 4);
            foreach ($orderInTransactions as $oit) {
                $qty = $oit->orderQty;
                $itemDescription = wordwrap($oit->itemName, 13, "\n".$four, false);
                $itemPrice =  $oit->itemPrice;
                $itemNote = $oit->itemNote;

                $orderTransaction[] =['QTY' => $qty,
                                    'DESCRIPTION' =>  $itemDescription."\n"."Note:".$itemNote
                                     ];

            }
            $printer -> setTextSize(2,2);
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $printer -> text(texttable::table($orderTransaction));
            unset($orderTransaction);

            foreach ($orderInTransactionDetails as $oitd) {
                $note =  $oitd->transactionNote;
                $printer -> setTextSize(2,2);
                $printer -> setJustification(Printer::FONT_C);
                $printer -> setJustification(Printer::JUSTIFY_LEFT);
                $printer -> text("Note:".$note."\n");
            }



            //Footer
            $date = date("Y-m-d H:i:s");
            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_C);
            $printer -> setJustification(Printer::JUSTIFY_CENTER);
            $printer -> text("Date:".$date."\n");



            $printer -> cut();

            /* Close printer */
            $printer -> close();
        } catch (Exception $e) {
        }
    }

    public function printClickOutsourced($transactionId){



        $orderTransaction = [];
        $orderDetails = [];
        try {
            $device = DB::select("SELECT deviceName  FROM devices WHERE departmentId = 4");

            // Enter the share name for your printer here, as a smb:// url format
            $connector = new WindowsPrintConnector($device[0]->deviceName);
            //$connector = new WindowsPrintConnector("smb://Guest@computername/Receipt Printer");
            //$connector = new WindowsPrintConnector("smb://FooUser:secret@computername/workgroup/Receipt Printer");
            //$connector = new WindowsPrintConnector("smb://User:secret@computername/Receipt Printer");



            /* Print a "Hello world" receipt" */
            $printer = new Printer($connector);

            $orderInTransactions=  DB::table('transactions')
            ->leftjoin('orders', 'transactions.transactionId', '=', 'orders.transactionId')
            ->leftjoin('tables', 'tables.tableId', '=', 'transactions.transactionTableId')
            ->leftjoin('items', 'orders.itemId', '=', 'items.itemId')
            ->leftjoin('categories', 'items.categoryId', '=', 'categories.categoryId')
            ->leftjoin('departments', 'categories.departmentId', '=', 'departments.departmentId')
            ->where('departments.departmentId', '=' , '4')
            ->where('transactions.transactionStatus', '!=' , 'Available')
            ->where('orders.transactionId', '=' , $transactionId)
            ->where('orders.orderStatus', '=' , '0')
            ->get()->toArray();


            $orderInTransactionDetails =  DB::select('SELECT *,
                                                    (
                                                    SELECT SUM(orderPrice)
                                                    FROM orders z
                                                    LEFT JOIN categories y ON y.categoryId = z.categoryId
                                                    LEFT JOIN departments w ON y.departmentId = w.departmentId
                                                    WHERE
                                                    w.departmentId = 4) AS total
                                                    FROM transactions a
                                                    LEFT JOIN tables c ON a.transactionTableId = c.tableId
                                                    WHERE a.transactionId ='.$transactionId.'
                                                    ' );

            foreach ($orderInTransactionDetails as $oitd) {
                $tableNo =  $oitd->tableNumber;
                $transactionSlipNo =  $oitd->transactionSlipNo;
                $header ="KITCHEN ORDER ".$tableNo."";
                //header
                $printer -> setTextSize(2,2);
                $printer -> setJustification(Printer::FONT_C);
                $printer -> setJustification(Printer::JUSTIFY_CENTER);
                $printer -> text("".$header."\n");

                $printer -> setTextSize(1,1);
                $printer -> setJustification(Printer::FONT_C);
                $printer -> setJustification(Printer::JUSTIFY_CENTER);
                $printer -> text("TN:".$transactionSlipNo."\n");
                $printer -> text("\n");

            }



            $footerSpace =  str_repeat(' ', 15);
            foreach ($orderInTransactionDetails as $oitd) {
                $total = $oitd->total;
                $serveBy = $oitd->transactionServedBy;
                $tableNo =  $oitd->tableName;
                $transactionSlipNo =  $oitd->transactionSlipNo;

                $printer -> setTextSize(1,1);
                $printer -> setJustification(Printer::FONT_C);
                $printer -> setJustification(Printer::JUSTIFY_LEFT);
                $printer -> text("Served By:".$serveBy."\n");
                $printer -> text("\n");

            }

            $four =  str_repeat(' ', 4);
            foreach ($orderInTransactions as $oit) {
                $qty = $oit->orderQty;
                $itemDescription = wordwrap($oit->itemName, 13, "\n".$four, false);
                $itemPrice =  $oit->itemPrice;
                $itemNote = $oit->itemNote;

                $orderTransaction[] =['QTY' => $qty,
                                    'DESCRIPTION' =>  $itemDescription."\n"."Note:".$itemNote
                                     ];

            }
            $printer -> setTextSize(2,2);
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $printer -> text(texttable::table($orderTransaction));
            unset($orderTransaction);

            foreach ($orderInTransactionDetails as $oitd) {
                $note =  $oitd->transactionNote;
                $printer -> setTextSize(2,2);
                $printer -> setJustification(Printer::FONT_C);
                $printer -> setJustification(Printer::JUSTIFY_LEFT);
                $printer -> text("Note:".$note."\n");
            }

            //Footer
            $date = date("Y-m-d H:i:s");
            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_C);
            $printer -> setJustification(Printer::JUSTIFY_CENTER);
            $printer -> text("Date:".$date."\n");



            $printer -> cut();

            /* Close printer */
            $printer -> close();
        } catch (Exception $e) {
        }



}

    public function printReceipt(Request $request){

        $transactionId = $request->transactionId;
        $customerName = $request->customerName;
        if(is_null($customerName))
            $customerName = "";
        $tenderedAmount = $request->tenderedAmount;
        $discount = $request->discount;


        $orderTransaction = [];
        $orderDetails = [];

        try {
            $user = Auth::user();
            $device = DB::select("SELECT deviceName  FROM devices WHERE departmentId = 3");
            $oic = DB::select("SELECT fullname  FROM users WHERE id =".$_SESSION['user_id']."");
            // Enter the share name for your printer here, as a smb:// url format
            $connector = new WindowsPrintConnector($device[0]->deviceName);
            // $connector = new NetworkPrintConnector("192.168.254.171", 9100);
            //$connector = new WindowsPrintConnector("smb://Guest@computername/Receipt Printer");
            //$connector = new WindowsPrintConnector("smb://FooUser:secret@computername/workgroup/Receipt Printer");
            //$connector = new WindowsPrintConnector("smb://User:secret@computername/Receipt Printer");

            $printer = new Printer($connector);

            $orderInTransactions=  DB::table('transactions')
                ->leftjoin('orders', 'transactions.transactionId', '=', 'orders.transactionId')
                ->leftjoin('tables', 'tables.tableId', '=', 'transactions.transactionTableId')
                ->leftjoin('items', 'orders.itemId', '=', 'items.itemId')
                ->leftjoin('categories', 'items.categoryId', '=', 'categories.categoryId')
                ->leftjoin('departments', 'categories.departmentId', '=', 'departments.departmentId')
                ->where('transactions.transactionStatus', '!=' , 'Available')
                ->where('transactions.transactionId', '=' , $transactionId)
                ->get()->toArray();


            $orderInTransactionDetails =  DB::select('SELECT *,
                                                    (
                                                    SELECT SUM(orderTotal)
                                                    FROM orders z
                                                    LEFT JOIN categories y ON y.categoryId = z.categoryId
                                                    LEFT JOIN departments w ON y.departmentId = w.departmentId
                                                    WHERE z.transactionId = '.$transactionId.') AS total
                                                    FROM transactions a
                                                    LEFT JOIN tables c ON a.transactionTableId = c.tableId
                                                    WHERE a.transactionId ='.$transactionId.'
                                                    ');

            /**
             * Print receipt twice
             *
             */
            // for($total_copies = 1, $two_copies = 2; $total_copies <= $two_copies; $total_copies++) {
                foreach ($orderInTransactionDetails as $oitd) {
                    $tableNo =  $oitd->tableNumber;
                    $transactionSlipNo =  $oitd->transactionSlipNo;
                    $company ="House of Z";
                    $address ="Baguio City Philippines 2600";
                    $tin = "TIN# ";
                    $cashier = $oic[0]->fullname;
                    $customer =  $customerName ;

                    //header
                    $printer -> setTextSize(2,2);
                    $printer -> setJustification(Printer::FONT_B);
                    $printer -> setJustification(Printer::JUSTIFY_CENTER);
                    $printer -> text("".$company."\n");

                    $printer -> setTextSize(1,1);
                    $printer -> setJustification(Printer::FONT_B);
                    $printer -> setJustification(Printer::JUSTIFY_CENTER);
                    $printer -> text("".$address."\n");

                    $printer -> setTextSize(1,1);
                    $printer -> setJustification(Printer::FONT_B);
                    $printer -> setJustification(Printer::JUSTIFY_CENTER);
                    $printer -> text("".$tin."\n");
                    $printer -> text("\n");

                    $printer -> setTextSize(1,1);
                    $printer -> setJustification(Printer::FONT_C);
                    $printer -> setJustification(Printer::JUSTIFY_LEFT);
                    $printer -> text("Cashier:".$cashier."\n");

                    $printer -> setTextSize(1,1);
                    $printer -> setJustification(Printer::FONT_C);
                    $printer -> setJustification(Printer::JUSTIFY_LEFT);
                    $printer -> text("Customer:".$customer."\n");

                    $printer -> setTextSize(1,1);
                    $printer -> setJustification(Printer::FONT_C);
                    $printer -> setJustification(Printer::JUSTIFY_LEFT);
                    $printer -> text("Sales Inv#:".$transactionSlipNo."\n");

                    $printer -> setTextSize(1,1);
                    $printer -> setJustification(Printer::FONT_C);
                    $printer -> setJustification(Printer::JUSTIFY_LEFT);
                    $printer -> text("Table#:".$tableNo."\n");

                }

                $totalItemCount = 0;
                foreach ($orderInTransactions as $oit) {
                    $qty = $oit->orderQty;
                    $itemDescription = strlen($oit->itemName) > 15 ? substr($oit->itemName,0,15)."..." : $oit->itemName;
                    $itemPrice =  $oit->itemPrice;
                    $totalItemCount += $oit->orderQty;

                    $orderTransaction[] =['Item' =>$itemDescription,
                                        'Price' =>number_format($itemPrice, 2),
                                        'Qty' =>$qty,
                                        'Amount' => number_format($itemPrice * $qty, 2)
                                         ];

                }
                $printer -> text(texttable::table($orderTransaction));

                $printer -> setTextSize(1,1);
                $printer -> setJustification(Printer::FONT_C);
                $printer -> setJustification(Printer::JUSTIFY_RIGHT);
                $printer -> text("***Item Count:".$totalItemCount."***\n");


                    $total = 0;
                foreach ($orderInTransactionDetails as $oitd) {
                    $total = $oitd->total;

                    $printer -> setTextSize(1,1);
                    $printer -> setJustification(Printer::FONT_C);
                    $printer -> setJustification(Printer::JUSTIFY_RIGHT);
                    $displayTotal = sprintf('%-5.40s %-1.05s %13s','TOTAL',':',number_format($total, 2));
                    $printer -> text("$displayTotal\n");

                    $displayDiscount= sprintf('%-4.40s %-1.05s %13s','DISCOUNT',':',number_format($discount, 2));
                    $printer -> text("$displayDiscount\n");


                    $payment = payment::create([
                        'transactionId' => $transactionId,
                        'customer' => $customerName ,
                        'totalAmount' =>  $total,
                        'discount' => $discount ,
                        'tenderedAmount' => $tenderedAmount,
                        'change' =>  $tenderedAmount + $discount - $total,
                        'accountReceivableAmount' =>  0,
                        'created_at' => now(),
                        'updated_at' => NULL,
                    ]);

                    $update_transaction = transaction::where('transactionId', $transactionId)
                        ->update([
                            'transactionStatus' => 'Available'
                        ]);
                }

                $printer -> setTextSize(1,1);
                $printer -> setJustification(Printer::FONT_C);
                $printer -> setJustification(Printer::JUSTIFY_RIGHT);
                $displayCash = sprintf('%-5.40s %-1.05s %13s','CASH',':',number_format($tenderedAmount, 2));
                $printer -> text("$displayCash\n");

                $printer -> setTextSize(1,1);
                $printer -> setJustification(Printer::FONT_C);
                $printer -> setJustification(Printer::JUSTIFY_RIGHT);
                $displayChange= sprintf('%-5.40s %-1.05s %13s','CHANGE',':',number_format($tenderedAmount + $discount - $total, 2));
                $printer -> text("$displayChange\n");

                $printer -> setTextSize(1,1);
                $line = str_repeat(".", 48);
                $printer -> text("" .$line."\n");

                $printer -> setTextSize(1,1);
                $printer -> setJustification(Printer::FONT_C);
                $printer -> setJustification(Printer::JUSTIFY_RIGHT);
                $vatSale = sprintf('%-5.40s %-1.05s %25s','VAT SALE',':', number_format(($saleVat  = $total / 1.12), 2));
                $printer -> text("$vatSale\n");

                $printer -> setTextSize(1,1);
                $printer -> setJustification(Printer::FONT_C);
                $printer -> setJustification(Printer::JUSTIFY_RIGHT);
                $vatExempt = sprintf('%-5.40s %-1.05s %25s','VAT EXEMPT',':', number_format('0', 2));
                $printer -> text("$vatExempt\n");

                $printer -> setTextSize(1,1);
                $printer -> setJustification(Printer::FONT_C);
                $printer -> setJustification(Printer::JUSTIFY_RIGHT);
                $vatZeroRatedSales = sprintf('%-5.40s %-1.05s %25s','VAT ZERO RATED SALES',':', number_format('0', 2));
                $printer -> text("$vatZeroRatedSales\n");

                $printer -> setTextSize(1,1);
                $printer -> setJustification(Printer::FONT_C);
                $printer -> setJustification(Printer::JUSTIFY_RIGHT);
                $totalSale = sprintf('%-5.40s %-1.05s %25s','TOTAL SALE',':', number_format($total - $discount, 2));
                $printer -> text("$totalSale\n");

                $printer -> setTextSize(1,1);
                $printer -> setJustification(Printer::FONT_C);
                $printer -> setJustification(Printer::JUSTIFY_RIGHT);
                $vat = sprintf('%-5.40s %-1.05s %25s','12% VAT',':', number_format($saleVat * 0.12, 2));
                $printer -> text("$vat\n");

                $line = str_repeat(".", 48);
                $printer -> text("" .$line."\n \n \n");

                $printer -> setJustification(Printer::JUSTIFY_CENTER);
                $line_dash = str_repeat("_", 40);
                $printer -> text("" .$line_dash."\n");
                $printer -> text("Customer Signature Over Printed Name\n");

                $line = str_repeat(".", 48);
                $printer -> text("" .$line."\n");

                //Footer
                $date = date("Y-m-d H:i:s");
                $printer -> setJustification(Printer::JUSTIFY_CENTER);
                $printer -> text("Date/Time:".$date."\n");

                $developedBy = "Developed By \n SAHEI CORE TECHNOLOGIES CO. \n Suite 205 LYMAN OGILBY CENTRUM \n #358 MAGSAYSAY AVENUE, BAGUIO CITY \n Landline:(774) 422 4729 \n Mobile:0961-594-6257 \n Email:saheicoretech@gmail.com \n Website: https://saheicore.tech";
                $printer -> setJustification(Printer::JUSTIFY_CENTER);
                $printer -> text("".$developedBy."\n");
            // }

            $printer -> cut();
            $printer -> pulse();
            /* Close printer */
            $printer -> close();
            $data = [
                'transactionStatus' => 'Available',
                'updated_at' => now(),
            ];
            $transaction = transaction::where('transactionId', $transactionId)->update($data);
        } catch (Exception $e) {
            return response('200', 'Printer not found');
        }
    }

    public function printARReceipt(Request $request){

        $transactionId = $request->transactionId;
        $customerName = $request->customerName;
        if(is_null($customerName))
            $customerName = "";
        $tenderedAmount = 0;
        $discount = $request->discount;


        $orderTransaction = [];
        $orderDetails = [];

        try {
            $user = Auth::user();
            $device = DB::select("SELECT deviceName  FROM devices WHERE departmentId = 3");
            $oic = DB::select("SELECT fullname  FROM users WHERE id =".$_SESSION['user_id']."");
            // Enter the share name for your printer here, as a smb:// url format
            $connector = new WindowsPrintConnector($device[0]->deviceName);
            // $connector = new NetworkPrintConnector("192.168.254.171", 9100);
            //$connector = new WindowsPrintConnector("smb://Guest@computername/Receipt Printer");
            //$connector = new WindowsPrintConnector("smb://FooUser:secret@computername/workgroup/Receipt Printer");
            //$connector = new WindowsPrintConnector("smb://User:secret@computername/Receipt Printer");

            $printer = new Printer($connector);

            $orderInTransactions=  DB::table('transactions')
            ->leftjoin('orders', 'transactions.transactionId', '=', 'orders.transactionId')
            ->leftjoin('tables', 'tables.tableId', '=', 'transactions.transactionTableId')
            ->leftjoin('items', 'orders.itemId', '=', 'items.itemId')
            ->leftjoin('categories', 'items.categoryId', '=', 'categories.categoryId')
            ->leftjoin('departments', 'categories.departmentId', '=', 'departments.departmentId')
            ->where('transactions.transactionStatus', '!=' , 'Available')
            ->where('transactions.transactionId', '=' , $transactionId)
            ->get()->toArray();


            $orderInTransactionDetails =  DB::select('SELECT *,
                                                    (
                                                    SELECT SUM(orderTotal)
                                                    FROM orders z
                                                    LEFT JOIN categories y ON y.categoryId = z.categoryId
                                                    LEFT JOIN departments w ON y.departmentId = w.departmentId
                                                    WHERE z.transactionId = '.$transactionId.') AS total
                                                    FROM transactions a
                                                    LEFT JOIN tables c ON a.transactionTableId = c.tableId
                                                    WHERE a.transactionId ='.$transactionId.'
                                                    ');


            foreach ($orderInTransactionDetails as $oitd) {
                $tableNo =  $oitd->tableNumber;
                $transactionSlipNo =  $oitd->transactionSlipNo;
                $company ="House of Z";
                $address ="Baguio City Philippines 2600";
                $tin = "TIN# ";
                $cashier = $oic[0]->fullname;
                $customer =  $customerName ;

                //header
                $printer -> setTextSize(2,2);
                $printer -> setJustification(Printer::FONT_B);
                $printer -> setJustification(Printer::JUSTIFY_CENTER);
                $printer -> text("".$company."\n");

                $printer -> setTextSize(1,1);
                $printer -> setJustification(Printer::FONT_B);
                $printer -> setJustification(Printer::JUSTIFY_CENTER);
                $printer -> text("".$address."\n");

                $printer -> setTextSize(1,1);
                $printer -> setJustification(Printer::FONT_B);
                $printer -> setJustification(Printer::JUSTIFY_CENTER);
                $printer -> text("".$tin."\n");
                $printer -> text("\n");

                $printer -> setTextSize(1,1);
                $printer -> setJustification(Printer::FONT_C);
                $printer -> setJustification(Printer::JUSTIFY_LEFT);
                $printer -> text("Cashier:".$cashier."\n");

                $printer -> setTextSize(1,1);
                $printer -> setJustification(Printer::FONT_C);
                $printer -> setJustification(Printer::JUSTIFY_LEFT);
                $printer -> text("Customer:".$customer."\n");

                $printer -> setTextSize(1,1);
                $printer -> setJustification(Printer::FONT_C);
                $printer -> setJustification(Printer::JUSTIFY_LEFT);
                $printer -> text("Sales Inv#:".$transactionSlipNo."\n");

                $printer -> setTextSize(1,1);
                $printer -> setJustification(Printer::FONT_C);
                $printer -> setJustification(Printer::JUSTIFY_LEFT);
                $printer -> text("Table#:".$tableNo."\n");

            }


            foreach ($orderInTransactions as $oit) {
                $qty = $oit->orderQty;
                $itemDescription = strlen($oit->itemName) > 15 ? substr($oit->itemName,0,15)."..." : $oit->itemName;
                $itemPrice =  $oit->itemPrice;

                $orderTransaction[] =['Item' =>$itemDescription,
                                    'Price' =>number_format($itemPrice, 2),
                                    'Qty' =>$qty,
                                    'Amount' => number_format($itemPrice * $qty, 2)
                                     ];

            }
            $printer -> text(texttable::table($orderTransaction));

            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_C);
            $printer -> setJustification(Printer::JUSTIFY_RIGHT);
            $printer -> text("***Item Count:".count($orderInTransactions)."***\n");


                $total = 0;
            foreach ($orderInTransactionDetails as $oitd) {
                $total = $oitd->total;

                $printer -> setTextSize(1,1);
                $printer -> setJustification(Printer::FONT_C);
                $printer -> setJustification(Printer::JUSTIFY_RIGHT);
                $displayTotal = sprintf('%-5.40s %-1.05s %13s','AR TOTAL',':',number_format($total, 2));
                $printer -> text("$displayTotal\n");

                $displayDiscount= sprintf('%-4.40s %-1.05s %13s','DISCOUNT',':',number_format($discount, 2));
                $printer -> text("$displayDiscount\n");


                $payment = payment::create([
                    'transactionId' => $transactionId,
                    'customer' => $customerName ,
                    'totalAmount' => $total,
                    'discount' => $discount ,
                    'tenderedAmount' => $tenderedAmount,
                    'change' =>  $tenderedAmount + $discount - $total,
                    'accountReceivableAmount' =>  $total,
                    'created_at' => now(),
                    'updated_at' => NULL,
                ]);

                $update_transaction = transaction::where('transactionId', $transactionId)
                        ->update([
                            'transactionStatus' => 'Available'
                        ]);
            }

            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_C);
            $printer -> setJustification(Printer::JUSTIFY_RIGHT);
            $displayCash = sprintf('%-5.40s %-1.05s %13s','CASH',':',number_format($tenderedAmount, 2));
            $printer -> text("$displayCash\n");


            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_C);
            $printer -> setJustification(Printer::JUSTIFY_RIGHT);
            $displayChange= sprintf('%-5.40s %-1.05s %13s','CHANGE',':',number_format('0', 2));
            $printer -> text("$displayChange\n");

            $printer -> setTextSize(1,1);
            $line = str_repeat(".", 48);
            $printer -> text("" .$line."\n");

            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_C);
            $printer -> setJustification(Printer::JUSTIFY_RIGHT);
            $vatSale = sprintf('%-5.40s %-1.05s %25s','VAT SALE',':', number_format(($saleVat  = $total / 1.12), 2));
            $printer -> text("$vatSale\n");


            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_C);
            $printer -> setJustification(Printer::JUSTIFY_RIGHT);
            $vatExempt = sprintf('%-5.40s %-1.05s %25s','VAT EXEMPT',':', number_format('0', 2));
            $printer -> text("$vatExempt\n");

            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_C);
            $printer -> setJustification(Printer::JUSTIFY_RIGHT);
            $vatZeroRatedSales = sprintf('%-5.40s %-1.05s %25s','VAT ZERO RATED SALES',':', number_format('0', 2));
            $printer -> text("$vatZeroRatedSales\n");

            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_C);
            $printer -> setJustification(Printer::JUSTIFY_RIGHT);
            $totalSale = sprintf('%-5.40s %-1.05s %25s','TOTAL SALE',':', number_format($total - $discount, 2));
            $printer -> text("$totalSale\n");

            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_C);
            $printer -> setJustification(Printer::JUSTIFY_RIGHT);
            $vat = sprintf('%-5.40s %-1.05s %25s','12% VAT',':', number_format($saleVat * 0.12, 2));
            $printer -> text("$vat\n");

            $line = str_repeat(".", 48);
            $printer -> text("" .$line."\n \n \n");

            $printer -> setJustification(Printer::JUSTIFY_CENTER);
            $line_dash = str_repeat("_", 40);
            $printer -> text("" .$line_dash."\n");
            $printer -> text("Customer Signature Over Printed Name\n");

            $line = str_repeat(".", 48);
            $printer -> text("" .$line."\n");

            //Footer
            $date = date("Y-m-d H:i:s");
            $printer -> setJustification(Printer::JUSTIFY_CENTER);
            $printer -> text("Date/Time:".$date."\n");

            // $footerNote = "This Invoice/Reciept shall be valid for \n five(5) years from the date of permit to use \n This Serves as your Official Receipt \n Thank you come again";

            // $printer -> setJustification(Printer::JUSTIFY_CENTER);
            // $printer -> text("".$footerNote."\n");



            $developedBy = "Developed By \n SAHEI CORE TECHNOLOGIES CO. \n Suite 205 LYMAN OGILBY CENTRUM \n #358 MAGSAYSAY AVENUE, BAGUIO CITY \n Landline:(774) 422 4729 \n Mobile:0961-594-6257 \n Email:saheicoretech@gmail.com \n Website: https://saheicore.tech";
            $printer -> setJustification(Printer::JUSTIFY_CENTER);
            $printer -> text("".$developedBy."\n");




            $printer -> cut();
            $printer -> pulse();
            /* Close printer */
            $printer -> close();
            $data = [
                'transactionStatus' => 'Available',
                'updated_at' => now(),
            ];
            $transaction = transaction::where('transactionId', $transactionId)->update($data);
        } catch (Exception $e) {
            return response('200', 'Printer not found');
        }
    }

    public function printShiftReport(Request $request){

        $onethousand = $request->onethousand;
        $fivehundred = $request->fivehundred;
        $twohundred = $request->twohundred;
        $onehundred = $request->onehundred;
        $fifty = $request->fifty;
        $twenty = $request->twenty;
        $ten = $request->ten;
        $five = $request->five;
        $one = $request->one;
        $cents = $request->cents;
        $sumcheques = $request->sumcheques;
        $totalcashcount = $request->totalcashcount;

        $beginningCash = 0;
        $additionalCash = 0;
        $payments =0;
        $totalCOH = $totalcashcount;
        $sales = $totalCOH- ($beginningCash + $additionalCash);
        $totalCredit = 0;
        $totalDiscount =0;
        $overShort = 0;
        $totalAccoumulateSales=$sales;

        $category =[];
        $items = [];

        try {
            $user = Auth::user();
            $device = DB::select("SELECT deviceName  FROM devices WHERE departmentId = 3");
            $oic = DB::select("SELECT fullname  FROM users WHERE id =".$_SESSION['user_id']."");
            // Enter the share name for your printer here, as a smb:// url format
            $connector = new WindowsPrintConnector($device[0]->deviceName);
            //$connector = new WindowsPrintConnector("smb://Guest@computername/Receipt Printer");
            //$connector = new WindowsPrintConnector("smb://FooUser:secret@computername/workgroup/Receipt Printer");
            //$connector = new WindowsPrintConnector("smb://User:secret@computername/Receipt Printer");

            $printer = new Printer($connector);

            $company ="House of Z";
            $address ="Baguio City Philippines 2600";
            $tin = "TIN# ";
            $cashier = $oic[0]->fullname;


            //header
            $printer -> setTextSize(2,2);
            $printer -> setJustification(Printer::FONT_B);
            $printer -> setJustification(Printer::JUSTIFY_CENTER);
            $printer -> text("".$company."\n");

            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_B);
            $printer -> setJustification(Printer::JUSTIFY_CENTER);
            $printer -> text("".$address."\n");

            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_B);
            $printer -> setJustification(Printer::JUSTIFY_CENTER);
            $printer -> text("".$tin."\n");
            $printer -> text("\n");

            $date = now();
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $printer -> text("Date/Time:".$date."\n");

            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_C);
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $printer -> text("Cashier:".$cashier."\n");

            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_C);
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $printer -> text("Cash Count"."\n");

            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_C);
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $displayCashCountHeader= sprintf('%-5.40s %18s %8s','Denomination','No. of Pcs.','Amount');
            $printer -> text("".$displayCashCountHeader ."\n");
            $printer -> text("\n");

            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_C);
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $displayOnethousand = sprintf('%-5.40s %13s %13s','One Thousand',$onethousand, number_format(1000 * $onethousand, 2));
            $printer -> text("".$displayOnethousand ."\n");


            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_C);
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $displayFivehundred = sprintf('%-5.40s %13s %13s','Five Hundred',$fivehundred, number_format(500 * $fivehundred, 2));
            $printer -> text("".$displayFivehundred ."\n");

            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_C);
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $displayTwohundred = sprintf('%-5.40s %14s %13s','Two Hundred',$twohundred, number_format(200 * $twohundred, 2));
            $printer -> text("".$displayTwohundred ."\n");

            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_C);
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $displayOnehundred = sprintf('%-5.40s %14s %13s','One Hundred',$onehundred, number_format(100 * $onehundred, 2));
            $printer -> text("".$displayOnehundred ."\n");

            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_C);
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $displayFifty= sprintf('%-5.40s %20s %13s','Fifty',$fifty, number_format(50 * $fifty, 2));
            $printer -> text("".$displayFifty ."\n");

            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_C);
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $displayTwenty= sprintf('%-5.40s %19s %13s','Twenty',$twenty, number_format(20 * $twenty, 2));
            $printer -> text("".$displayTwenty ."\n");

            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_C);
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $displayTen= sprintf('%-5.40s %20s %13s','Ten',$ten, number_format(10 * $ten, 2));
            $printer -> text("".$displayTen ."\n");

            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_C);
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $displayFive= sprintf('%-5.40s %20s %13s','Five',$five, number_format(5 * $five, 2));
            $printer -> text("".$displayFive ."\n");


            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_C);
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $displayOne= sprintf('%-5.40s %20s %13s','One',$one, number_format(1 * $one, 2));
            $printer -> text("".$displayOne ."\n");

            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_C);
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $displayCents= sprintf('%-5.40s %17s %13s','25 Cents',$cents, number_format(.25 * $cents, 2));
            $printer -> text("".$displayCents ."\n");

            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_C);
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $displaySumCheques= sprintf('%-5.40s %28s %13s','Sum Cheques',number_format($sumcheques, 2), '');
            $printer -> text("".$displaySumCheques ."\n");


            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_C);
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $displayTotalCashCount= sprintf('%-5.40s %1s %13s','Total Cash Count',':', number_format($totalcashcount, 2));
            $printer -> text("".$displayTotalCashCount ."\n");


            $line = str_repeat(".", 48);
            $printer -> text("" .$line."\n");

            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_C);
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $printer -> text("POS TRANSACTIONS"."\n");


            $beginingfund =  DB::select('SELECT  beginingAmount
            FROM beginingfunds WHERE beginingfundUserId  = ' .$_SESSION['user_id'].'
            ');

            $beginningCash = $beginingfund[0]->beginingAmount;

            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_C);
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $displayBegCash= sprintf('%-5.40s %1s %30s','Beg Cash',':', number_format($beginningCash, 2));
            $printer -> text($displayBegCash."\n");

            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_C);
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $displayAdditionalCash= sprintf('%-5.40s %1s %23s','Additional Cash',':', number_format($additionalCash, 2));
            $printer -> text($displayAdditionalCash."\n");

            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_C);
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $displayPayments= sprintf('%-5.40s %1s %30s','Payments',':', number_format($payments, 2));
            $printer -> text($displayPayments."\n");

            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_C);
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $displaySales= sprintf('%-5.40s %1s %33s','Sales',':', number_format($sales, 2));
            $printer -> text($displaySales."\n");

            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_C);
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $displayTotalCOH= sprintf('%-5.40s %1s %29s','Total COH',':', number_format($totalCOH, 2));
            $printer -> text($displayTotalCOH."\n");


            // $printer -> setTextSize(1,1);
            // $printer -> setJustification(Printer::FONT_C);
            // $printer -> setJustification(Printer::JUSTIFY_LEFT);
            // $printer -> text("Total Refunds"."\n");

            // $printer -> setTextSize(1,1);
            // $printer -> setJustification(Printer::FONT_C);
            // $printer -> setJustification(Printer::JUSTIFY_LEFT);
            // $printer -> text("Pickup"."\n");

            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_C);
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $displayTotalCredit= sprintf('%-5.40s %1s %26s','Total Credit',':', number_format($totalCredit, 2));
            $printer -> text($displayTotalCredit."\n");



            $discountTotal =  DB::select('SELECT  SUM(discount) AS totalDiscount
            FROM payments a
            LEFT JOIN transactions b ON a.transactionId = b.transactionId
            WHERE b.transactionUserId  = ' .$_SESSION['user_id'].' AND DATE_FORMAT(b.created_at,"%d/%m/%Y")  = DATE_FORMAT(now(),"%d/%m/%Y")
            ');

            $totalDiscount = $discountTotal[0]->totalDiscount;

            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_C);
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $displayTotalDiscount= sprintf('%-5.40s %1s %24s','Total Discount',':', number_format($totalDiscount, 2));
            $printer -> text($displayTotalDiscount."\n");

            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_C);
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $printer -> text("Total Cash Count + Sum Cheques - (Total COH Pickup)"."\n");

            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_C);
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $displayOverShort= sprintf('%-5.40s %1s %27s','Over/Short',':', number_format($overShort, 2));
            $printer -> text($displayOverShort."\n");

            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_C);
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $displayTotalAccumulatedSales= sprintf('%-5.40s %1s %14s','TOTAL ACCUMULATED SALES',':', number_format($totalAccoumulateSales, 2));
            $printer -> text($displayTotalAccumulatedSales."\n");


            $line = str_repeat(".", 48);
            $printer -> text("" .$line."\n");

            //first




            $itemsArray =  DB::select('SELECT * ,
            (SELECT SUM(orderQty) FROM orders z WHERE z.itemId = d.itemId AND DATE_FORMAT(z.created_at,"%d/%m/%Y") = DATE_FORMAT(now(),"%d/%m/%Y")) AS itemQTY,
            (SELECT SUM(orderQty * orderPrice) FROM orders y WHERE y.itemId = d.itemId AND DATE_FORMAT(y.created_at,"%d/%m/%Y") = DATE_FORMAT(now(),"%d/%m/%Y")) AS itemTotal
            FROM transactions a
            LEFT JOIN orders b ON a.transactionId = b.transactionId
            LEFT JOIN items d ON b.itemId = d.itemId
            WHERE DATE_FORMAT(a.created_at,"%d/%m/%Y") = DATE_FORMAT(now(),"%d/%m/%Y") AND a.transactionUserId =' .$_SESSION['user_id'].'
            GROUP BY d.itemId
            ');

            $categoryArray =  DB::select('SELECT * ,
            (SELECT SUM(orderQty) FROM orders z WHERE  e.categoryId = z.categoryId AND DATE_FORMAT(z.created_at,"%d/%m/%Y") = DATE_FORMAT(now(),"%d/%m/%Y")) AS GrandQtyForThisCategory,
            (SELECT SUM(orderQty * orderPrice) FROM orders y WHERE e.categoryId = y.categoryId AND DATE_FORMAT(y.created_at,"%d/%m/%Y") = DATE_FORMAT(now(),"%d/%m/%Y")) AS GrandTotalForThisCategory
            FROM transactions a
            LEFT JOIN orders b ON a.transactionId = b.transactionId
            LEFT JOIN items d ON b.itemId = d.itemId
            LEFT JOIN categories e ON e.categoryId = b.categoryId
            WHERE DATE_FORMAT(a.created_at,"%d/%m/%Y") = DATE_FORMAT(now(),"%d/%m/%Y") AND a.transactionUserId =' .$_SESSION['user_id'].'
            GROUP BY d.categoryId
            ');

            $grandTotal =  DB::select('SELECT  SUM(orderQty) AS totalQTY ,SUM(orderQty * orderPrice) AS totalAmount
            FROM orders a
            LEFT JOIN transactions b ON a.transactionId = b.transactionId
            WHERE  DATE_FORMAT(a.created_at,"%d/%m/%Y") = DATE_FORMAT(NOW(),"%d/%m/%Y") AND b.transactionUserId = ' .$_SESSION['user_id'].'
            ');








            $thisArray = [];
            foreach ($categoryArray as $category) {
                $categoryName = strlen( $category->categoryName) > 30 ? substr( $category->categoryName,0,30)."..." :  $category->categoryName;
                $categoryId =  $category->categoryId;
                $GrandQtyForThisCategory =  $category->GrandQtyForThisCategory;
                $GrandTotalForThisCategory =  $category->GrandTotalForThisCategory;


                $printer -> setTextSize(1,1);
                $printer -> setJustification(Printer::FONT_C);
                $printer -> setJustification(Printer::JUSTIFY_LEFT);
                $printer -> text("".$categoryName."\n");

                foreach ($itemsArray as $item) {
                    $itemCategoryId =  $item->categoryId;
                    $itemName = strlen($item->itemName) > 20 ? substr($item->itemName,0,20)."..." :  $item->itemName;
                    $itemQTY =  $item->itemQTY;
                    $itemTotal =  $item->itemTotal;

                    if($categoryId == $itemCategoryId){

                        $thisArray[] =['Item Description' =>$itemName,
                                        'Amount' =>number_format($itemTotal, 2),
                                        'Qty' =>$itemQTY,
                                        ];

                    }
                }
                $printer -> setJustification(Printer::JUSTIFY_CENTER);
                $printer -> text(texttable::table($thisArray));
                unset($thisArray);

                $displaySum = sprintf('%-5.40s %15s %15s','Sum',"PHP".number_format($GrandTotalForThisCategory,2),$GrandQtyForThisCategory);

                $printer -> setTextSize(1,1);
                $printer -> setJustification(Printer::FONT_C);
                $printer -> setJustification(Printer::JUSTIFY_LEFT);
                $printer -> text(" $displaySum\n");
                $printer -> text("\n");


            }

            $line = str_repeat(".", 48);
            $printer -> text("" .$line."\n");


            $displayGrandTotal = sprintf('%-5.40s %15s %15s','Grand Total',"PHP".number_format($grandTotal[0]->totalAmount,2),$grandTotal[0]->totalQTY);
            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_C);
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $printer -> text("$displayGrandTotal\n");
            $printer -> text("\n");


            $line = str_repeat(".", 48);
            $printer -> text("" .$line."\n");


            $developedBy = "Developed By \n SAHEI CORE TECHNOLOGIES CO. \n Suite 205 LYMAN OGILBY CENTRUM \n #358 MAGSAYSAY AVENUE, BAGUIO CITY \n Landline:(774) 422 4729 \n Mobile:0961-594-6257 \n Email:saheicoretech@gmail.com \n Website: https://saheicore.tech";
            $printer -> setJustification(Printer::JUSTIFY_CENTER);
            $printer -> text("".$developedBy."\n");




            $printer -> cut();

            /* Close printer */
            $printer -> close();



        } catch (Exception $e) {

        }

    }

    public function testShiftReport(Request $request){
        $dateCompare = Carbon::now()->format('d/m/Y');
        if(!is_null($request->date) && $request->date != '')
        $dateCompare = Carbon::parse($request->date)->format('d/m/Y');

        /**
         * Cash count
         */
        $onethousand = $request->cash['onethousand'];
        $fivehundred = $request->cash['fivehundred'];
        $twohundred = $request->cash['twohundred'];
        $onehundred = $request->cash['onehundred'];
        $fifty = $request->cash['fifty'];
        $twenty = $request->cash['twenty'];
        $ten = $request->cash['ten'];
        $five = $request->cash['five'];
        $one = $request->cash['one'];
        $cents = $request->cash['cents'];
        $sumcheques = $request->cash['sumcheques'];
        $totalcashcount = $request->cash['totalcashcount'];

        /**
         * Voucher count
         */
        $v_onethousand = $request->voucher['onethousand'];
        $v_fivehundred = $request->voucher['fivehundred'];
        $v_twohundred = $request->voucher['twohundred'];
        $v_onehundred = $request->voucher['onehundred'];
        $v_fifty = $request->voucher['fifty'];
        $v_twenty = $request->voucher['twenty'];
        $v_ten = $request->voucher['ten'];
        $v_totalcashcount = $request->voucher['totalcashcount'];

        $category =[];
        $items = [];

        try {
            $user = Auth::user();
            $device = DB::select("SELECT deviceName  FROM devices WHERE departmentId = 3");
            $oic = DB::select("SELECT fullname  FROM users WHERE id =".$_SESSION['user_id']."");
            // Enter the share name for your printer here, as a smb:// url format
            $connector = new WindowsPrintConnector($device[0]->deviceName);
            //$connector = new WindowsPrintConnector("smb://Guest@computername/Receipt Printer");
            //$connector = new WindowsPrintConnector("smb://FooUser:secret@computername/workgroup/Receipt Printer");
            //$connector = new WindowsPrintConnector("smb://User:secret@computername/Receipt Printer");

            $printer = new Printer($connector);

            $company ="House of Z";
            $address ="Baguio City Philippines 2600";
            $tin = "TIN# ";
            $cashier = $oic[0]->fullname;


            //header
            $printer -> setTextSize(2,2);
            $printer -> setJustification(Printer::FONT_B);
            $printer -> setJustification(Printer::JUSTIFY_CENTER);
            $printer -> text("".$company."\n");

            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_B);
            $printer -> setJustification(Printer::JUSTIFY_CENTER);
            $printer -> text("".$address."\n");

            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_B);
            $printer -> setJustification(Printer::JUSTIFY_CENTER);
            $printer -> text("".$tin."\n");
            $printer -> text("\n");

            // $date = now();
            $date = Carbon::now()->format('Y-m-d H:i:s');
            if(!is_null($request->date) && $request->date != '')
                $date = Carbon::parse($request->date)->format('Y-m-d');
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $printer -> text("Date/Time:".$date."\n");

            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_C);
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $printer -> text("Cashier:".$cashier."\n");

            /**
             * Start print cash count
             */
            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_C);
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $printer -> text("Cash Count"."\n");

            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_C);
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $displayCashCountHeader= sprintf('%-5.40s %18s %8s','Denomination','No. of Pcs.','Amount');
            $printer -> text("".$displayCashCountHeader ."\n");
            $printer -> text("\n");

            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_C);
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $displayOnethousand = sprintf('%-5.40s %13s %13s','One Thousand',$onethousand, number_format(1000 * $onethousand, 2));
            $printer -> text("".$displayOnethousand ."\n");


            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_C);
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $displayFivehundred = sprintf('%-5.40s %13s %13s','Five Hundred',$fivehundred, number_format(500 * $fivehundred, 2));
            $printer -> text("".$displayFivehundred ."\n");

            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_C);
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $displayTwohundred = sprintf('%-5.40s %14s %13s','Two Hundred',$twohundred, number_format(200 * $twohundred, 2));
            $printer -> text("".$displayTwohundred ."\n");

            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_C);
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $displayOnehundred = sprintf('%-5.40s %14s %13s','One Hundred',$onehundred, number_format(100 * $onehundred, 2));
            $printer -> text("".$displayOnehundred ."\n");

            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_C);
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $displayFifty= sprintf('%-5.40s %20s %13s','Fifty',$fifty, number_format(50 * $fifty, 2));
            $printer -> text("".$displayFifty ."\n");

            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_C);
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $displayTwenty= sprintf('%-5.40s %19s %13s','Twenty',$twenty, number_format(20 * $twenty, 2));
            $printer -> text("".$displayTwenty ."\n");

            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_C);
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $displayTen= sprintf('%-5.40s %20s %13s','Ten',$ten, number_format(10 * $ten, 2));
            $printer -> text("".$displayTen ."\n");

            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_C);
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $displayFive= sprintf('%-5.40s %20s %13s','Five',$five, number_format(5 * $five, 2));
            $printer -> text("".$displayFive ."\n");


            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_C);
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $displayOne= sprintf('%-5.40s %20s %13s','One',$one, number_format(1 * $one, 2));
            $printer -> text("".$displayOne ."\n");

            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_C);
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $displayCents= sprintf('%-5.40s %17s %13s','25 Cents',$cents, number_format(.25 * $cents, 2));
            $printer -> text("".$displayCents ."\n");

            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_C);
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $displaySumCheques= sprintf('%-5.40s %28s %13s','Sum Cheques',number_format($sumcheques, 2), '');
            $printer -> text("".$displaySumCheques ."\n");


            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_C);
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $displayTotalCashCount= sprintf('%-5.40s %1s %13s','Total Cash Count',':', number_format($totalcashcount, 2));
            $printer -> text("".$displayTotalCashCount ."\n");
            /**
             * End print cash count
             */

            /**
             * Start print voucher count
             */
            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_C);
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $printer -> text("Voucher Count"."\n");

            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_C);
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $displayCashCountHeader= sprintf('%-5.40s %18s %8s','Denomination','No. of Pcs.','Amount');
            $printer -> text("".$displayCashCountHeader ."\n");
            $printer -> text("\n");

            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_C);
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $v_displayOnethousand = sprintf('%-5.40s %13s %13s','One Thousand',$v_onethousand, number_format(1000 * $v_onethousand, 2));
            $printer -> text("".$v_displayOnethousand ."\n");


            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_C);
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $v_displayFivehundred = sprintf('%-5.40s %13s %13s','Five Hundred',$v_fivehundred, number_format(500 * $v_fivehundred, 2));
            $printer -> text("".$v_displayFivehundred ."\n");

            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_C);
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $v_displayTwohundred = sprintf('%-5.40s %14s %13s','Two Hundred',$v_twohundred, number_format(200 * $v_twohundred, 2));
            $printer -> text("".$v_displayTwohundred ."\n");

            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_C);
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $v_displayOnehundred = sprintf('%-5.40s %14s %13s','One Hundred',$v_onehundred, number_format(100 * $v_onehundred, 2));
            $printer -> text("".$v_displayOnehundred ."\n");

            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_C);
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $v_displayFifty= sprintf('%-5.40s %20s %13s','Fifty',$v_fifty, number_format(50 * $v_fifty, 2));
            $printer -> text("".$v_displayFifty ."\n");

            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_C);
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $v_displayTwenty= sprintf('%-5.40s %19s %13s','Twenty',$v_twenty, number_format(20 * $v_twenty, 2));
            $printer -> text("".$v_displayTwenty ."\n");

            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_C);
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $v_displayTen= sprintf('%-5.40s %20s %13s','Ten',$v_ten, number_format(10 * $v_ten, 2));
            $printer -> text("".$v_displayTen ."\n");

            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_C);
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $v_displayTotalCashCount= sprintf('%-5.40s %1s %13s','Total Cash Count',':', number_format($v_totalcashcount, 2));
            $printer -> text("".$v_displayTotalCashCount ."\n");
            /**
             * End print voucher count
             */


            $line = str_repeat(".", 48);
            $printer -> text("" .$line."\n");

            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_C);
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $printer -> text("POS TRANSACTIONS"."\n");


            $beginingfund =  DB::select('SELECT  beginingAmount
            FROM beginingfunds WHERE beginingfundUserId  = ' .$_SESSION['user_id'].' AND DATE_FORMAT(created_at,"%d/%m/%Y")  = "'. $dateCompare .'"
            ');


            $beginningCash = $beginingfund[0]->beginingAmount;

            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_C);
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $displayBegCash= sprintf('%-5.40s %1s %30s','Beg Cash',':', number_format($beginningCash, 2));
            $printer -> text($displayBegCash."\n");


            $additionalCashTotal =  DB::select('SELECT SUM(amount) as totalAdditionalCash FROM cashins WHERE cashinUserId =  ' .$_SESSION['user_id'].'
            AND DATE_FORMAT(created_at,"%d/%m/%Y") = "'. $dateCompare .'"
            ');

            $totalAdditionalCash = $additionalCashTotal[0]->totalAdditionalCash;

            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_C);
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $displayAdditionalCash= sprintf('%-5.40s %1s %15s','Additional Cash(Cashin)',':', number_format($totalAdditionalCash, 2));
            $printer -> text($displayAdditionalCash."\n");

            $saleTotal =  DB::select('SELECT  SUM(orderQty * orderPrice) AS totalSale
            FROM orders a
            LEFT JOIN transactions b ON a.transactionId = b.transactionId
            WHERE  DATE_FORMAT(a.created_at,"%d/%m/%Y") = "'. $dateCompare .'" AND b.transactionUserId = ' .$_SESSION['user_id'].'
            ');

            $totalSale = $saleTotal[0]->totalSale;

            $ar = DB::select('SELECT  SUM(accountReceivableAmount) as totalAmount from payments a
            LEFT JOIN transactions b ON a.transactionId = b.transactionId
            WHERE a.accountReceivableAmount IS NOT NULL AND a.accountReceivableAmount != 0
            AND b.transactionUserId = ' .$_SESSION['user_id'].' AND DATE_FORMAT(a.created_at,"%d/%m/%Y") = "'. $dateCompare .'"
            ');

            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_C);
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $displaySales= sprintf('%-5.40s %1s %33s','Sales',':', number_format($totalSale =  $totalSale - $ar[0]->totalAmount, 2));
            $printer -> text($displaySales."\n");

            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_C);
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $displayTotalCOH= sprintf('%-5.40s %1s %29s','Total COH',':', number_format($totalCOH = $beginningCash + $totalAdditionalCash + $totalSale, 2));
            $printer -> text($displayTotalCOH."\n");


            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_C);
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $displayTotalCredit= sprintf('%-5.40s %1s %26s','Total Credit',':', number_format($totalCredit = 0, 2));
            $printer -> text($displayTotalCredit."\n");



            $discountTotal =  DB::select('SELECT  SUM(discount) AS totalDiscount
            FROM payments a
            LEFT JOIN transactions b ON a.transactionId = b.transactionId
            WHERE b.transactionUserId  = ' .$_SESSION['user_id'].' AND DATE_FORMAT(b.created_at,"%d/%m/%Y")  = "'. $dateCompare .'"
            ');

            $totalDiscount = $discountTotal[0]->totalDiscount;

            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_C);
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $displayTotalDiscount= sprintf('%-5.40s %1s %24s','Total Discount',':', number_format($totalDiscount, 2));
            $printer -> text($displayTotalDiscount."\n");

            $paymentTotal =  DB::select('SELECT SUM(amount) as totalPayment FROM cashouts WHERE cashoutUserId =  ' .$_SESSION['user_id'].'
            AND DATE_FORMAT(created_at,"%d/%m/%Y") = "'. $dateCompare .'"
            ');

            $totalPayment = $paymentTotal[0]->totalPayment;

            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_C);
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $displayPayments= sprintf('%-5.40s %1s %21s','Payments(Cashout)',':', number_format($totalPayment, 2));
            $printer -> text($displayPayments."\n");

            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_C);
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $printer -> text("Total Cash Count + Sum Cheques - (Total COH Pickup)"."\n");

            $totalLess = $totalCredit + $totalDiscount + $totalPayment;

            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_C);
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $displayOverShort= sprintf('%-5.40s %1s %27s','Over/Short',':', number_format($overShort =  $totalcashcount - ($totalCOH  -  $totalLess), 2));
            $printer -> text($displayOverShort."\n");

            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_C);
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $displayTotalAccumulatedSales= sprintf('%-5.40s %1s %14s','TOTAL ACCUMULATED SALES',':', number_format($totalAccoumulateSales = $beginningCash + $totalAdditionalCash + $totalSale, 2));
            $printer -> text($displayTotalAccumulatedSales."\n");

            $line = str_repeat(".", 48);
            $printer -> text("" .$line."\n");

            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_C);
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $printer -> text("Note\n");

            $line = str_repeat(".", 48);
            $printer -> text("" .$line."\n \n \n \n \n");


            $itemsArray =  DB::select('SELECT * ,
            (SELECT SUM(orderQty) FROM orders z WHERE z.itemId = d.itemId AND DATE_FORMAT(z.created_at,"%d/%m/%Y") = "'. $dateCompare .'") AS itemQTY,
            (SELECT SUM(orderQty * orderPrice) FROM orders y WHERE y.itemId = d.itemId AND DATE_FORMAT(y.created_at,"%d/%m/%Y") = "'. $dateCompare .'") AS itemTotal
            FROM transactions a
            LEFT JOIN orders b ON a.transactionId = b.transactionId
            LEFT JOIN items d ON b.itemId = d.itemId
            WHERE DATE_FORMAT(a.created_at,"%d/%m/%Y") = "'. $dateCompare .'" AND a.transactionUserId =' .$_SESSION['user_id'].'
            GROUP BY d.itemId
            ');


            $categoryArray =  DB::select('SELECT * ,
            (SELECT SUM(orderQty) FROM orders z WHERE  e.categoryId = z.categoryId AND DATE_FORMAT(z.created_at,"%d/%m/%Y") = "'. $dateCompare .'") AS GrandQtyForThisCategory,
            (SELECT SUM(orderQty * orderPrice) FROM orders y WHERE e.categoryId = y.categoryId AND DATE_FORMAT(y.created_at,"%d/%m/%Y") = "'. $dateCompare .'") AS GrandTotalForThisCategory
            FROM transactions a
            LEFT JOIN orders b ON a.transactionId = b.transactionId
            LEFT JOIN items d ON b.itemId = d.itemId
            LEFT JOIN categories e ON e.categoryId = b.categoryId
            WHERE DATE_FORMAT(a.created_at,"%d/%m/%Y") = "'. $dateCompare .'" AND a.transactionUserId =' .$_SESSION['user_id'].'
            GROUP BY d.categoryId
            ');

            $grandTotal =  DB::select('SELECT  SUM(orderQty) AS totalQTY ,SUM(orderQty * orderPrice) AS totalAmount
            FROM orders a
            LEFT JOIN transactions b ON a.transactionId = b.transactionId
            LEFT JOIN payments c ON b.transactionId = c.transactionId
            WHERE  DATE_FORMAT(a.created_at,"%d/%m/%Y") = "'. $dateCompare .'" AND b.transactionUserId = ' .$_SESSION['user_id']. '
            ');

            $cashinArray = DB::select('SELECT * FROM cashins WHERE cashinUserId =  ' .$_SESSION['user_id'].'
            AND DATE_FORMAT(created_at,"%d/%m/%Y") = "'. $dateCompare .'"
            ');

            $cashinTotal = DB::select('SELECT SUM(amount) as totalAmount FROM cashins WHERE cashinUserId =  ' .$_SESSION['user_id'].'
            AND DATE_FORMAT(created_at,"%d/%m/%Y") = "'. $dateCompare .'"
            ');

            $cashoutArray = DB::select('SELECT * FROM cashouts WHERE cashoutUserId =  ' .$_SESSION['user_id'].'
            AND DATE_FORMAT(created_at,"%d/%m/%Y") = "'. $dateCompare .'"
            ');

            $cashoutTotal = DB::select('SELECT SUM(amount) as totalAmount FROM cashouts WHERE cashoutUserId =  ' .$_SESSION['user_id'].'
            AND DATE_FORMAT(created_at,"%d/%m/%Y") = "'. $dateCompare .'"
            ');

            $discountArray = DB::select('SELECT * from payments a
            LEFT JOIN transactions b ON a.transactionId = b.transactionId
            WHERE a.discount IS NOT NULL AND a.discount != 0
            AND b.transactionUserId =  ' .$_SESSION['user_id'].'  AND DATE_FORMAT(a.created_at,"%d/%m/%Y") ="'. $dateCompare .'"
            ');

            $discountTotal = DB::select('SELECT SUM(discount) as totalAmount from payments a
            LEFT JOIN transactions b ON a.transactionId = b.transactionId
            WHERE a.discount IS NOT NULL AND a.discount != 0
            AND b.transactionUserId =  ' .$_SESSION['user_id'].'  AND DATE_FORMAT(a.created_at,"%d/%m/%Y") ="'. $dateCompare .'"
            ');


            $ArArray = DB::select('SELECT  *  from payments a
            LEFT JOIN transactions b ON a.transactionId = b.transactionId
            WHERE a.accountReceivableAmount IS NOT NULL AND a.accountReceivableAmount != 0
            AND b.transactionUserId = ' .$_SESSION['user_id'].' AND DATE_FORMAT(a.created_at,"%d/%m/%Y") = "'. $dateCompare .'"
            ');


            $ArTotal = DB::select('SELECT  SUM(accountReceivableAmount) as totalAmount from payments a
            LEFT JOIN transactions b ON a.transactionId = b.transactionId
            WHERE a.accountReceivableAmount IS NOT NULL AND a.accountReceivableAmount != 0
            AND b.transactionUserId = ' .$_SESSION['user_id'].' AND DATE_FORMAT(a.created_at,"%d/%m/%Y") = "'. $dateCompare .'"
            ');


            $ordersArray = [];
            foreach ($categoryArray as $category) {
                $categoryName = strlen( $category->categoryName) > 30 ? substr( $category->categoryName,0,30)."..." :  $category->categoryName;
                $categoryId =  $category->categoryId;
                $GrandQtyForThisCategory =  $category->GrandQtyForThisCategory;
                $GrandTotalForThisCategory =  $category->GrandTotalForThisCategory;


                $printer -> setTextSize(1,1);
                $printer -> setJustification(Printer::FONT_C);
                $printer -> setJustification(Printer::JUSTIFY_LEFT);
                $printer -> text("".$categoryName."\n");

                foreach ($itemsArray as $item) {
                    $itemCategoryId =  $item->categoryId;
                    $itemName = strlen($item->itemName) > 20 ? substr($item->itemName,0,20)."..." :  $item->itemName;
                    $itemQTY =  $item->itemQTY;
                    $itemTotal =  $item->itemTotal;

                    if($categoryId == $itemCategoryId){

                        $ordersArray[] =['Item Description' =>$itemName,
                                        'Amount' =>number_format($itemTotal, 2),
                                        'Qty' =>$itemQTY,
                                        ];

                    }
                }
                $printer -> setJustification(Printer::JUSTIFY_CENTER);
                $printer -> text(texttable::table($ordersArray));
                unset($ordersArray);

                $displaySum = sprintf('%-5.40s %15s %15s','Sum',"PHP".number_format($GrandTotalForThisCategory,2),$GrandQtyForThisCategory);

                $printer -> setTextSize(1,1);
                $printer -> setJustification(Printer::FONT_C);
                $printer -> setJustification(Printer::JUSTIFY_LEFT);
                $printer -> text(" $displaySum\n");
                $printer -> text("\n");


            }

            $line = str_repeat(".", 48);
            $printer -> text("" .$line."\n");

            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_C);
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $printer -> text("Additional Cash(Cashin)\n \n");

            $CIArray =[];
            foreach ($cashinArray as $ci) {
                $givenBy = strlen( $ci->giveBy) > 10 ? substr($ci->giveBy,0,10)."..." :  $ci->giveBy;
                $amount =  $ci->amount;
                $note =   strlen( $ci->note) > 10 ? substr($ci->note,0,10)."..." :  $ci->note;
                $CIArray[] =['Given By' =>$givenBy,
                'Amount' =>number_format($amount, 2),
                'Note' =>$note,
                ];
            }

            $printer -> setJustification(Printer::JUSTIFY_CENTER);
            $printer -> text(texttable::table($CIArray));
            unset($CIArray);

            $displayCashinTotal = sprintf('%-5.40s %15s','Additional Cash(Cashin) Total',"PHP".number_format($cashinTotal[0]->totalAmount,2));
            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_C);
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $printer -> text("$displayCashinTotal\n");
            $printer -> text("\n");

            $line = str_repeat(".", 48);
            $printer -> text("" .$line."\n");

            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_C);
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $printer -> text("Payments(Cashout)\n \n");

            $COArray =[];
            foreach ($cashoutArray as $co) {
                $receivedBy = strlen( $co->receiveBy) > 10 ? substr($co->receiveBy,0,10)."..." :  $co->receiveBy;
                $amount =  $co->amount;
                $note =   strlen( $co->note) > 10 ? substr($co->note,0,10)."..." :  $co->note;
                $COArray[] =['Receive By' =>$receivedBy,
                'Amount' =>number_format($amount, 2),
                'Note' =>$note,
                ];
            }

            $printer -> setJustification(Printer::JUSTIFY_CENTER);
            $printer -> text(texttable::table($COArray));
            unset($COArray);

            $displayCashoutTotal = sprintf('%-5.40s %15s','Payments(Cashout) Total',"PHP".number_format($cashoutTotal[0]->totalAmount,2));
            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_C);
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $printer -> text("$displayCashoutTotal\n");
            $printer -> text("\n");

            $line = str_repeat(".", 48);
            $printer -> text("" .$line."\n");

            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_C);
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $printer -> text("Discount\n \n");

            $dArray = [];
            foreach ($discountArray as $d) {
                $transactionSlipNo =  $d->transactionSlipNo;
                $amount =  $d->discount;

                $dArray[] =['Slip No' =>$transactionSlipNo,
                'Amount' =>number_format($amount, 2),
                ];
            }

            $printer -> setJustification(Printer::JUSTIFY_CENTER);
            $printer -> text(texttable::table($dArray));
            unset($dArray);

            $displayDiscountTotal = sprintf('%-5.40s %15s','Discount Total',"PHP".number_format($discountTotal[0]->totalAmount,2));
            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_C);
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $printer -> text("$displayDiscountTotal\n");
            $printer -> text("\n");

            $line = str_repeat(".", 48);
            $printer -> text("" .$line."\n");

            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_C);
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $printer -> text("Accounts Receivable\n \n");

            $accountReceivableArray = [];
            foreach ($ArArray as $ar) {
                $transactionSlipNo =  $ar->transactionSlipNo;
                $amount =  $ar->accountReceivableAmount;

                $accountReceivableArray[] =['Slip No' =>$transactionSlipNo,
                'Amount' =>number_format($amount, 2),
                ];
            }

            $printer -> setJustification(Printer::JUSTIFY_CENTER);
            $printer -> text(texttable::table($accountReceivableArray));
            unset($accountReceivableArray);

            $displaARTotal = sprintf('%-5.40s %15s','Accounts Receivable Total',"PHP".number_format($ArTotal[0]->totalAmount,2));
            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_C);
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $printer -> text("$displaARTotal\n");
            $printer -> text("\n");


            $line = str_repeat(".", 48);
            $printer -> text("" .$line."\n");


            $displayGrandTotal = sprintf('%-5.40s %15s %15s','Grand Total',"PHP".number_format($grandTotal[0]->totalAmount - $ArTotal[0]->totalAmount,2),$grandTotal[0]->totalQTY);
            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_C);
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $printer -> text("$displayGrandTotal\n");
            $printer -> text("\n");


            $line = str_repeat(".", 48);
            $printer -> text("" .$line."\n");


            $developedBy = "Developed By \n SAHEI CORE TECHNOLOGIES CO. \n Suite 205 LYMAN OGILBY CENTRUM \n #358 MAGSAYSAY AVENUE, BAGUIO CITY \n Landline:(774) 422 4729 \n Mobile:0961-594-6257 \n Email:saheicoretech@gmail.com \n Website: https://saheicore.tech";
            $printer -> setJustification(Printer::JUSTIFY_CENTER);
            $printer -> text("".$developedBy."\n");
            $printer -> cut();

            /* Close printer */
            $printer -> close();
        } catch (Exception $e) {

        }
    }



    public function allShiftReport(Request $request){
        $dateCompare = Carbon::now()->format('d/m/Y');
        if(!is_null($request->date) && $request->date != '')
            $dateCompare = Carbon::parse($request->date)->format('d/m/Y');

        /** cash count */
        $onethousand = $request->cash['onethousand'];
        $fivehundred = $request->cash['fivehundred'];
        $twohundred = $request->cash['twohundred'];
        $onehundred = $request->cash['onehundred'];
        $fifty = $request->cash['fifty'];
        $twenty = $request->cash['twenty'];
        $ten = $request->cash['ten'];
        $five = $request->cash['five'];
        $one = $request->cash['one'];
        $cents = $request->cash['cents'];
        $sumcheques = $request->cash['sumcheques'];
        $totalcashcount = $request->cash['totalcashcount'];

        /** voucher count */
        $v_onethousand = $request->voucher['onethousand'];
        $v_fivehundred = $request->voucher['fivehundred'];
        $v_twohundred = $request->voucher['twohundred'];
        $v_onehundred = $request->voucher['onehundred'];
        $v_fifty = $request->voucher['fifty'];
        $v_twenty = $request->voucher['twenty'];
        $v_ten = $request->voucher['ten'];
        $v_totalcashcount = $request->voucher['totalcashcount'];

        $category =[];
        $items = [];
        // get users under cashier role
        $cashiers = User::select('id')->where('role_id', 4)->get()->toArray();
        $cashiers = Arr::flatten($cashiers);
        $cashiers = implode(',', $cashiers);

        try {
            $user = Auth::user();
            $device = DB::select("SELECT deviceName  FROM devices WHERE departmentId = 3");
            $oic = DB::select("SELECT fullname  FROM users WHERE id =".$_SESSION['user_id']."");
            // Enter the share name for your printer here, as a smb:// url format
            $connector = new WindowsPrintConnector($device[0]->deviceName);
            //$connector = new WindowsPrintConnector("smb://Guest@computername/Receipt Printer");
            //$connector = new WindowsPrintConnector("smb://FooUser:secret@computername/workgroup/Receipt Printer");
            //$connector = new WindowsPrintConnector("smb://User:secret@computername/Receipt Printer");

            $printer = new Printer($connector);

            $company ="House of Z";
            $address ="Baguio City Philippines 2600";
            $tin = "TIN# ";
            $cashier = $oic[0]->fullname;


            //header
            $printer -> setTextSize(2,2);
            $printer -> setJustification(Printer::FONT_B);
            $printer -> setJustification(Printer::JUSTIFY_CENTER);
            $printer -> text("".$company."\n");

            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_B);
            $printer -> setJustification(Printer::JUSTIFY_CENTER);
            $printer -> text("".$address."\n");

            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_B);
            $printer -> setJustification(Printer::JUSTIFY_CENTER);
            $printer -> text("".$tin."\n");
            $printer -> text("\n");

            // $date = now();
            $date = Carbon::now()->format('Y-m-d H:i:s');
            if(!is_null($request->date) && $request->date != '')
                $date = Carbon::parse($request->date)->format('Y-m-d');
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $printer -> text("Date/Time:".$date."\n");

            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_C);
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $printer -> text("Cashier:".$cashier."\n");

            /**
             * start print cash count
             */
            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_C);
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $printer -> text("Cash Count"."\n");

            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_C);
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $displayCashCountHeader= sprintf('%-5.40s %18s %8s','Denomination','No. of Pcs.','Amount');
            $printer -> text("".$displayCashCountHeader ."\n");
            $printer -> text("\n");

            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_C);
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $displayOnethousand = sprintf('%-5.40s %13s %13s','One Thousand',$onethousand, number_format(1000 * $onethousand, 2));
            $printer -> text("".$displayOnethousand ."\n");


            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_C);
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $displayFivehundred = sprintf('%-5.40s %13s %13s','Five Hundred',$fivehundred, number_format(500 * $fivehundred, 2));
            $printer -> text("".$displayFivehundred ."\n");

            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_C);
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $displayTwohundred = sprintf('%-5.40s %14s %13s','Two Hundred',$twohundred, number_format(200 * $twohundred, 2));
            $printer -> text("".$displayTwohundred ."\n");

            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_C);
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $displayOnehundred = sprintf('%-5.40s %14s %13s','One Hundred',$onehundred, number_format(100 * $onehundred, 2));
            $printer -> text("".$displayOnehundred ."\n");

            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_C);
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $displayFifty= sprintf('%-5.40s %20s %13s','Fifty',$fifty, number_format(50 * $fifty, 2));
            $printer -> text("".$displayFifty ."\n");

            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_C);
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $displayTwenty= sprintf('%-5.40s %19s %13s','Twenty',$twenty, number_format(20 * $twenty, 2));
            $printer -> text("".$displayTwenty ."\n");

            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_C);
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $displayTen= sprintf('%-5.40s %20s %13s','Ten',$ten, number_format(10 * $ten, 2));
            $printer -> text("".$displayTen ."\n");

            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_C);
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $displayFive= sprintf('%-5.40s %20s %13s','Five',$five, number_format(5 * $five, 2));
            $printer -> text("".$displayFive ."\n");


            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_C);
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $displayOne= sprintf('%-5.40s %20s %13s','One',$one, number_format(1 * $one, 2));
            $printer -> text("".$displayOne ."\n");

            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_C);
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $displayCents= sprintf('%-5.40s %17s %13s','25 Cents',$cents, number_format(.25 * $cents, 2));
            $printer -> text("".$displayCents ."\n");

            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_C);
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $displaySumCheques= sprintf('%-5.40s %28s %13s','Sum Cheques',number_format($sumcheques, 2), '');
            $printer -> text("".$displaySumCheques ."\n");

            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_C);
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $displayTotalCashCount= sprintf('%-5.40s %1s %13s','Total Cash Count',':', number_format($totalcashcount, 2));
            $printer -> text("".$displayTotalCashCount ."\n");
            /**
             * end print cash count
             */

            /**
             * start print voucher count
             */
            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_C);
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $printer -> text("Voucher Count"."\n");

            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_C);
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $displayCashCountHeader= sprintf('%-5.40s %18s %8s','Denomination','No. of Pcs.','Amount');
            $printer -> text("".$displayCashCountHeader ."\n");
            $printer -> text("\n");

            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_C);
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $v_displayOnethousand = sprintf('%-5.40s %13s %13s','One Thousand',$v_onethousand, number_format(1000 * $v_onethousand, 2));
            $printer -> text("".$v_displayOnethousand ."\n");


            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_C);
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $v_displayFivehundred = sprintf('%-5.40s %13s %13s','Five Hundred',$v_fivehundred, number_format(500 * $v_fivehundred, 2));
            $printer -> text("".$v_displayFivehundred ."\n");

            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_C);
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $v_displayTwohundred = sprintf('%-5.40s %14s %13s','Two Hundred',$v_twohundred, number_format(200 * $v_twohundred, 2));
            $printer -> text("".$v_displayTwohundred ."\n");

            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_C);
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $v_displayOnehundred = sprintf('%-5.40s %14s %13s','One Hundred',$v_onehundred, number_format(100 * $v_onehundred, 2));
            $printer -> text("".$v_displayOnehundred ."\n");

            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_C);
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $v_displayFifty= sprintf('%-5.40s %20s %13s','Fifty',$v_fifty, number_format(50 * $v_fifty, 2));
            $printer -> text("".$v_displayFifty ."\n");

            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_C);
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $v_displayTwenty= sprintf('%-5.40s %19s %13s','Twenty',$v_twenty, number_format(20 * $v_twenty, 2));
            $printer -> text("".$v_displayTwenty ."\n");

            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_C);
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $v_displayTen= sprintf('%-5.40s %20s %13s','Ten',$v_ten, number_format(10 * $v_ten, 2));
            $printer -> text("".$v_displayTen ."\n");

            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_C);
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $v_displayTotalCashCount= sprintf('%-5.40s %1s %13s','Total Cash Count',':', number_format($v_totalcashcount, 2));
            $printer -> text("".$v_displayTotalCashCount ."\n");
            /**
             * end print voucher count
             */

            $line = str_repeat(".", 48);
            $printer -> text("" .$line."\n");

            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_C);
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $printer -> text("POS TRANSACTIONS"."\n");


            $beginingfund =  DB::select('SELECT  beginingAmount
            FROM beginingfunds WHERE beginingfundUserId  IN (' . $cashiers .') AND DATE_FORMAT(created_at,"%d/%m/%Y")  = "'. $dateCompare .'"
            ');
            $beginningCash = 0;
            if(count($beginingfund) > 0)
                $beginningCash = $beginingfund[0]->beginingAmount;

            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_C);
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $displayBegCash= sprintf('%-5.40s %1s %30s','Beg Cash',':', number_format($beginningCash, 2));
            $printer -> text($displayBegCash."\n");


            $additionalCashTotal =  DB::select('SELECT SUM(amount) as totalAdditionalCash FROM cashins WHERE cashinUserId  IN (' . $cashiers .')
            AND DATE_FORMAT(created_at,"%d/%m/%Y") = "'. $dateCompare .'"
            ');
            $totalAdditionalCash = $additionalCashTotal[0]->totalAdditionalCash;

            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_C);
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $displayAdditionalCash= sprintf('%-5.40s %1s %15s','Additional Cash(Cashin)',':', number_format($totalAdditionalCash, 2));
            $printer -> text($displayAdditionalCash."\n");

            $saleTotal =  DB::select('SELECT  SUM(orderQty * orderPrice) AS totalSale
            FROM orders a
            LEFT JOIN transactions b ON a.transactionId = b.transactionId
            WHERE  DATE_FORMAT(a.created_at,"%d/%m/%Y") = "'. $dateCompare .'" AND b.transactionUserId IN (' . $cashiers .')
            ');
            $totalSale = $saleTotal[0]->totalSale;

            $ar = DB::select('SELECT  SUM(accountReceivableAmount) as totalAmount from payments a
            LEFT JOIN transactions b ON a.transactionId = b.transactionId
            WHERE a.accountReceivableAmount IS NOT NULL AND a.accountReceivableAmount != 0
            AND b.transactionUserId IN (' . $cashiers .') AND DATE_FORMAT(a.created_at,"%d/%m/%Y") = "'. $dateCompare .'"
            ');

            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_C);
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $displaySales= sprintf('%-5.40s %1s %33s','Sales',':', number_format($totalSale = $totalSale - $ar[0]->totalAmount , 2));
            $printer -> text($displaySales."\n");

            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_C);
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $displayTotalCOH= sprintf('%-5.40s %1s %29s','Total COH',':', number_format($totalCOH = $beginningCash + $totalAdditionalCash + $totalSale, 2));
            $printer -> text($displayTotalCOH."\n");


            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_C);
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $displayTotalCredit= sprintf('%-5.40s %1s %26s','Total Credit',':', number_format($totalCredit = 0, 2));
            $printer -> text($displayTotalCredit."\n");



            $discountTotal =  DB::select('SELECT  SUM(discount) AS totalDiscount
            FROM payments a
            LEFT JOIN transactions b ON a.transactionId = b.transactionId
            WHERE b.transactionUserId IN (' . $cashiers .') AND DATE_FORMAT(b.created_at,"%d/%m/%Y")  = "'. $dateCompare .'"
            ');
            $totalDiscount = $discountTotal[0]->totalDiscount;

            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_C);
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $displayTotalDiscount= sprintf('%-5.40s %1s %24s','Total Discount',':', number_format($totalDiscount, 2));
            $printer -> text($displayTotalDiscount."\n");

            $paymentTotal =  DB::select('SELECT SUM(amount) as totalPayment FROM cashouts WHERE cashoutUserId IN (' . $cashiers .')
            AND DATE_FORMAT(created_at,"%d/%m/%Y") = "'. $dateCompare .'"
            ');
            $totalPayment = $paymentTotal[0]->totalPayment;

            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_C);
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $displayPayments= sprintf('%-5.40s %1s %21s','Payments(Cashout)',':', number_format($totalPayment, 2));
            $printer -> text($displayPayments."\n");

            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_C);
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $printer -> text("Total Cash Count + Sum Cheques - (Total COH Pickup)"."\n");

            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_C);
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $displayOverShort= sprintf('%-5.40s %1s %27s','Over/Short',':', number_format($overShort =   $totalSale - $totalcashcount, 2));
            $printer -> text($displayOverShort."\n");

            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_C);
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $displayTotalAccumulatedSales= sprintf('%-5.40s %1s %14s','TOTAL ACCUMULATED SALES',':', number_format($totalAccoumulateSales = $beginningCash + $totalAdditionalCash + $totalSale, 2));
            $printer -> text($displayTotalAccumulatedSales."\n");

            $line = str_repeat(".", 48);
            $printer -> text("" .$line."\n");

            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_C);
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $printer -> text("Note\n");

            $line = str_repeat(".", 48);
            $printer -> text("" .$line."\n \n \n \n \n");


            $itemsArray =  DB::select('SELECT * ,
            (SELECT SUM(orderQty) FROM orders z WHERE z.itemId = d.itemId AND DATE_FORMAT(z.created_at,"%d/%m/%Y") = "'. $dateCompare .'") AS itemQTY,
            (SELECT SUM(orderQty * orderPrice) FROM orders y WHERE y.itemId = d.itemId AND DATE_FORMAT(y.created_at,"%d/%m/%Y") = "'. $dateCompare .'") AS itemTotal
            FROM transactions a
            LEFT JOIN orders b ON a.transactionId = b.transactionId
            LEFT JOIN items d ON b.itemId = d.itemId
            WHERE DATE_FORMAT(a.created_at,"%d/%m/%Y") = "'. $dateCompare .'" AND a.transactionUserId IN (' . $cashiers .')
            GROUP BY d.itemId
            ');

            $categoryArray =  DB::select('SELECT * ,
            (SELECT SUM(orderQty) FROM orders z WHERE  e.categoryId = z.categoryId AND DATE_FORMAT(z.created_at,"%d/%m/%Y") = "'. $dateCompare .'") AS GrandQtyForThisCategory,
            (SELECT SUM(orderQty * orderPrice) FROM orders y WHERE e.categoryId = y.categoryId AND DATE_FORMAT(y.created_at,"%d/%m/%Y") = "'. $dateCompare .'") AS GrandTotalForThisCategory
            FROM transactions a
            LEFT JOIN orders b ON a.transactionId = b.transactionId
            LEFT JOIN items d ON b.itemId = d.itemId
            LEFT JOIN categories e ON e.categoryId = b.categoryId
            WHERE DATE_FORMAT(a.created_at,"%d/%m/%Y") = "'. $dateCompare .'" AND a.transactionUserId IN (' . $cashiers .')
            GROUP BY d.categoryId
            ');

            $grandTotal =  DB::select('SELECT  SUM(orderQty) AS totalQTY ,SUM(orderQty * orderPrice) AS totalAmount
            FROM orders a
            LEFT JOIN transactions b ON a.transactionId = b.transactionId
            WHERE  DATE_FORMAT(a.created_at,"%d/%m/%Y") = "'. $dateCompare .'" AND b.transactionUserId IN (' . $cashiers .')
            ');

            $cashinArray = DB::select('SELECT * FROM cashins WHERE cashinUserId IN (' . $cashiers .')
            AND DATE_FORMAT(created_at,"%d/%m/%Y") = "'. $dateCompare .'"
            ');

            $cashinTotal = DB::select('SELECT SUM(amount) as totalAmount FROM cashins WHERE cashinUserId IN (' . $cashiers .')
            AND DATE_FORMAT(created_at,"%d/%m/%Y") = "'. $dateCompare .'"
            ');

            $cashoutArray = DB::select('SELECT * FROM cashouts WHERE cashoutUserId IN (' . $cashiers .')
            AND DATE_FORMAT(created_at,"%d/%m/%Y") = "'. $dateCompare .'"
            ');

            $cashoutTotal = DB::select('SELECT SUM(amount) as totalAmount FROM cashouts WHERE cashoutUserId IN (' . $cashiers .')
            AND DATE_FORMAT(created_at,"%d/%m/%Y") = "'. $dateCompare .'"
            ');

            $discountArray = DB::select('SELECT * from payments a
            LEFT JOIN transactions b ON a.transactionId = b.transactionId
            WHERE a.discount IS NOT NULL AND a.discount != 0
            AND b.transactionUserId IN (' . $cashiers .')  AND DATE_FORMAT(a.created_at,"%d/%m/%Y") ="'. $dateCompare .'"
            ');

            $discountTotal = DB::select('SELECT SUM(discount) as totalAmount from payments a
            LEFT JOIN transactions b ON a.transactionId = b.transactionId
            WHERE a.discount IS NOT NULL AND a.discount != 0
            AND b.transactionUserId IN (' . $cashiers .')  AND DATE_FORMAT(a.created_at,"%d/%m/%Y") ="'. $dateCompare .'"
            ');


            $ArArray = DB::select('SELECT  *  from payments a
            LEFT JOIN transactions b ON a.transactionId = b.transactionId
            WHERE a.accountReceivableAmount IS NOT NULL AND a.accountReceivableAmount != 0
            AND b.transactionUserId IN (' . $cashiers .') AND DATE_FORMAT(a.created_at,"%d/%m/%Y") = "'. $dateCompare .'"
            ');


            $ArTotal = DB::select('SELECT  SUM(accountReceivableAmount) as totalAmount from payments a
            LEFT JOIN transactions b ON a.transactionId = b.transactionId
            WHERE a.accountReceivableAmount IS NOT NULL AND a.accountReceivableAmount != 0
            AND b.transactionUserId IN (' . $cashiers .') AND DATE_FORMAT(a.created_at,"%d/%m/%Y") = "'. $dateCompare .'"
            ');


            $ordersArray = [];
            foreach ($categoryArray as $category) {
                $categoryName = strlen( $category->categoryName) > 30 ? substr( $category->categoryName,0,30)."..." :  $category->categoryName;
                $categoryId =  $category->categoryId;
                $GrandQtyForThisCategory =  $category->GrandQtyForThisCategory;
                $GrandTotalForThisCategory =  $category->GrandTotalForThisCategory;


                $printer -> setTextSize(1,1);
                $printer -> setJustification(Printer::FONT_C);
                $printer -> setJustification(Printer::JUSTIFY_LEFT);
                $printer -> text("".$categoryName."\n");

                foreach ($itemsArray as $item) {
                    $itemCategoryId =  $item->categoryId;
                    $itemName = strlen($item->itemName) > 20 ? substr($item->itemName,0,20)."..." :  $item->itemName;
                    $itemQTY =  $item->itemQTY;
                    $itemTotal =  $item->itemTotal;

                    if($categoryId == $itemCategoryId){

                        $ordersArray[] =['Item Description' =>$itemName,
                                        'Amount' =>number_format($itemTotal, 2),
                                        'Qty' =>$itemQTY,
                                        ];

                    }
                }
                $printer -> setJustification(Printer::JUSTIFY_CENTER);
                $printer -> text(texttable::table($ordersArray));
                unset($ordersArray);

                $displaySum = sprintf('%-5.40s %15s %15s','Sum',"PHP".number_format($GrandTotalForThisCategory,2),$GrandQtyForThisCategory);

                $printer -> setTextSize(1,1);
                $printer -> setJustification(Printer::FONT_C);
                $printer -> setJustification(Printer::JUSTIFY_LEFT);
                $printer -> text(" $displaySum\n");
                $printer -> text("\n");


            }

            $line = str_repeat(".", 48);
            $printer -> text("" .$line."\n");

            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_C);
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $printer -> text("Additional Cash(Cashin)\n \n");

            $CIArray =[];
            foreach ($cashinArray as $ci) {
                $givenBy = strlen( $ci->giveBy) > 10 ? substr($ci->giveBy,0,10)."..." :  $ci->giveBy;
                $amount =  $ci->amount;
                $note =   strlen( $ci->note) > 10 ? substr($ci->note,0,10)."..." :  $ci->note;
                $CIArray[] =['Given By' =>$givenBy,
                'Amount' =>number_format($amount, 2),
                'Note' =>$note,
                ];
            }

            $printer -> setJustification(Printer::JUSTIFY_CENTER);
            $printer -> text(texttable::table($CIArray));
            unset($CIArray);

            $displayCashinTotal = sprintf('%-5.40s %15s','Additional Cash(Cashin) Total',"PHP".number_format($cashinTotal[0]->totalAmount,2));
            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_C);
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $printer -> text("$displayCashinTotal\n");
            $printer -> text("\n");

            $line = str_repeat(".", 48);
            $printer -> text("" .$line."\n");

            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_C);
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $printer -> text("Payments(Cashout)\n \n");

            $COArray =[];
            foreach ($cashoutArray as $co) {
                $receivedBy = strlen( $co->receiveBy) > 10 ? substr($co->receiveBy,0,10)."..." :  $co->receiveBy;
                $amount =  $co->amount;
                $note =   strlen( $co->note) > 10 ? substr($co->note,0,10)."..." :  $co->note;
                $COArray[] =['Receive By' =>$receivedBy,
                'Amount' =>number_format($amount, 2),
                'Note' =>$note,
                ];
            }

            $printer -> setJustification(Printer::JUSTIFY_CENTER);
            $printer -> text(texttable::table($COArray));
            unset($COArray);

            $displayCashoutTotal = sprintf('%-5.40s %15s','Payments(Cashout) Total',"PHP".number_format($cashoutTotal[0]->totalAmount,2));
            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_C);
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $printer -> text("$displayCashoutTotal\n");
            $printer -> text("\n");

            $line = str_repeat(".", 48);
            $printer -> text("" .$line."\n");

            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_C);
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $printer -> text("Discount\n \n");

            $dArray = [];
            foreach ($discountArray as $d) {
                $transactionSlipNo =  $d->transactionSlipNo;
                $amount =  $d->discount;

                $dArray[] =['Slip No' =>$transactionSlipNo,
                'Amount' =>number_format($amount, 2),
                ];
            }

            $printer -> setJustification(Printer::JUSTIFY_CENTER);
            $printer -> text(texttable::table($dArray));
            unset($dArray);

            $displayDiscountTotal = sprintf('%-5.40s %15s','Discount Total',"PHP".number_format($discountTotal[0]->totalAmount,2));
            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_C);
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $printer -> text("$displayDiscountTotal\n");
            $printer -> text("\n");

            $line = str_repeat(".", 48);
            $printer -> text("" .$line."\n");

            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_C);
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $printer -> text("Accounts Receivable\n \n");

            $accountReceivableArray = [];
            foreach ($ArArray as $ar) {
                $transactionSlipNo =  $ar->transactionSlipNo;
                $amount =  $ar->accountReceivableAmount;

                $accountReceivableArray[] =['Slip No' =>$transactionSlipNo,
                'Amount' =>number_format($amount, 2),
                ];
            }

            $printer -> setJustification(Printer::JUSTIFY_CENTER);
            $printer -> text(texttable::table($accountReceivableArray));
            unset($accountReceivableArray);

            $displaARTotal = sprintf('%-5.40s %15s','Accounts Receivable Total',"PHP".number_format($ArTotal[0]->totalAmount,2));
            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_C);
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $printer -> text("$displaARTotal\n");
            $printer -> text("\n");


            $line = str_repeat(".", 48);
            $printer -> text("" .$line."\n");


            $displayGrandTotal = sprintf('%-5.40s %15s %15s','Grand Total',"PHP".number_format($grandTotal[0]->totalAmount,2),$grandTotal[0]->totalQTY);
            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_C);
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $printer -> text("$displayGrandTotal\n");
            $printer -> text("\n");


            $line = str_repeat(".", 48);
            $printer -> text("" .$line."\n");


            $developedBy = "Developed By \n SAHEI CORE TECHNOLOGIES CO. \n Suite 205 LYMAN OGILBY CENTRUM \n #358 MAGSAYSAY AVENUE, BAGUIO CITY \n Landline:(774) 422 4729 \n Mobile:0961-594-6257 \n Email:saheicoretech@gmail.com \n Website: https://saheicore.tech";
            $printer -> setJustification(Printer::JUSTIFY_CENTER);
            $printer -> text("".$developedBy."\n");

            $printer -> cut();

            /* Close printer */
            $printer -> close();
        } catch (Exception $e) {

        }
    }

    function testShift(){
        $itemsArray =  DB::select('SELECT * ,
        (SELECT SUM(orderQty) FROM orders z WHERE z.itemId = d.itemId) AS itemQTY,
        (SELECT SUM(orderQty * orderPrice) FROM orders y WHERE y.itemId = d.itemId) AS itemTotal
        FROM transactions a
        LEFT JOIN orders b ON a.transactionId = b.transactionId
        LEFT JOIN items d ON b.itemId = d.itemId
        GROUP BY d.itemId
        ');

        $categoryArray =  DB::select('SELECT * ,
        (SELECT SUM(orderQty) FROM orders z WHERE  e.categoryId = z.categoryId) AS GrandQtyForThisCategory,
        (SELECT SUM(orderQty * orderPrice) FROM orders y WHERE e.categoryId = y.categoryId) AS GrandTotalForThisCategory
        FROM transactions a
        LEFT JOIN orders b ON a.transactionId = b.transactionId
        LEFT JOIN items d ON b.itemId = d.itemId
        LEFT JOIN categories e ON e.categoryId = b.categoryId
        GROUP BY d.categoryId
        ');

        $thisArray = [];
        foreach ($categoryArray as $category) {


            $categoryName = strlen( $category->categoryName) > 15 ? substr( $category->categoryName,0,15)."..." :  $category->categoryName;
            $categoryId =  $category->categoryId;
            $GrandQtyForThisCategory =  $category->GrandQtyForThisCategory;
            $GrandTotalForThisCategory =  $category->GrandTotalForThisCategory;

            echo $categoryName;
            echo '<br>';


            foreach ($itemsArray as $item) {


                $itemCategoryId =  $item->categoryId;
                $itemName = strlen($item->itemName) > 15 ? substr($item->itemName,0,15)."..." :  $item->itemName;
                $itemQTY =  $item->itemQTY;
                $itemTotal =  $item->itemTotal;

                if($categoryId == $itemCategoryId){

                    $thisArray[] =['Item Description' =>$itemName,
                                    'Amount' =>number_format($itemTotal, 2),
                                    'Qty' =>$itemQTY,
                                    ];


                }

                // echo $itemName;
            }
            echo texttable::table($thisArray);
            echo '<br>';
            unset($thisArray);


        }


    }



    public function getOrderInTransaction($transactionId) {
        $orderInTransactions=  DB::table('transactions')
        ->leftjoin('orders', 'transactions.transactionId', '=', 'orders.transactionId')
        ->leftjoin('tables', 'tables.tableId', '=', 'transactions.transactionTableId')
        ->leftjoin('items', 'orders.itemId', '=', 'items.itemId')
        ->leftjoin('categories', 'items.categoryId', '=', 'categories.categoryId')
        ->leftjoin('departments', 'categories.departmentId', '=', 'departments.departmentId')
        ->where('departments.departmentId', '=' , '1')
        ->where('transactions.transactionStatus', '!=' , 'Available')
        ->where('orders.orderStatus', '=' , '0')
        ->where('transactions.transactionId', '=' , $transactionId)
        ->get()->toArray();

        return $orderInTransactions;

    }

    public function getOrderInTransactionDetails($transactionId) {
        $orderInTransactionDetails =  DB::select('SELECT *,
                                        (SELECT SUM(orderTotal) FROM orders b  WHERE b.transactionId = '.$transactionId.') AS total
                                        FROM transactions a
                                        LEFT JOIN tables c ON a.transactionTableId = c.tableId
                                        LEFT JOIN departments d ON d.departmentId = 1
                                        LEFT JOIN orders e ON e.transactionId = '.$transactionId.'
                                        WHERE a.transactionId ='.$transactionId.'
                                        AND a.transactionStatus != "Available"
                                        AND e.orderStatus = 0' );


        return $orderInTransactionDetails;

    }




    public function printCashIn($cashInId){
        try {
            $device =DB::select("SELECT deviceName  FROM devices WHERE departmentId = 3");
            // Enter the share name for your printer here, as a smb:// url format
            $connector = new WindowsPrintConnector($device[0]->deviceName);
            // $connector = new WindowsPrintConnector("smb://DESKTOP-EN0ACJM/EPSON TM-T82X");
            //$connector = new WindowsPrintConnector("smb://FooUser:secret@computername/workgroup/Receipt Printer");
            //$connector = new WindowsPrintConnector("smb://User:secret@computername/Receipt Printer");



            /* Print a "Hello world" receipt" */
            $printer = new Printer($connector);

            $cashins=  DB::table('cashins')
            ->where('cashins.cashInId', '=' , $cashInId)
            ->get()->toArray();


            foreach ($cashins as $cashin) {
                $givenBy =  $cashin->giveBy;
                $amount =  $cashin->amount;
                $note =  $cashin->note;
                $dateCreated =  $cashin->created_at;


                $header ="CASHIN";
                //header
                $printer -> setTextSize(2,2);
                $printer -> setJustification(Printer::FONT_C);
                $printer -> setJustification(Printer::JUSTIFY_CENTER);
                $printer -> text("".$header."\n");
                $printer -> text("\n \n \n");

                $printer -> setTextSize(1,1);
                $printer -> setJustification(Printer::FONT_C);
                $printer -> setJustification(Printer::JUSTIFY_LEFT);
                $printer -> text("Date:".$dateCreated."\n");
                $printer -> text("\n");

                $printer -> setTextSize(1,1);
                $printer -> setJustification(Printer::FONT_C);
                $printer -> setJustification(Printer::JUSTIFY_LEFT);
                $printer -> text("Given By:".$givenBy."\n");
                $printer -> text("\n");

                $printer -> setJustification(Printer::JUSTIFY_CENTER);
                $line_dash = str_repeat("_", 40);
                $printer -> text("" .$line_dash."\n");
                $printer -> text("Signature Over Printed Name\n \n");

                $printer -> setTextSize(1,1);
                $printer -> setJustification(Printer::FONT_C);
                $printer -> setJustification(Printer::JUSTIFY_LEFT);
                $printer -> text("Amount:". number_format($amount, 2)."\n");
                $printer -> text("\n");

                $printer -> setTextSize(1,1);
                $printer -> setJustification(Printer::FONT_C);
                $printer -> setJustification(Printer::JUSTIFY_CENTER);
                $printer -> text("Note:".$note."\n");
                $printer -> text("\n");



            }


            $printer -> cut();

            /* Close printer */
            $printer -> close();
        } catch (Exception $e) {
        }
    }

    public function printCashOut($cashOutId){

        try {
            $device =DB::select("SELECT deviceName  FROM devices WHERE departmentId = 3");
            // Enter the share name for your printer here, as a smb:// url format
            $connector = new WindowsPrintConnector($device[0]->deviceName);
            // $connector = new WindowsPrintConnector("smb://DESKTOP-EN0ACJM/EPSON TM-T82X");
            //$connector = new WindowsPrintConnector("smb://FooUser:secret@computername/workgroup/Receipt Printer");
            //$connector = new WindowsPrintConnector("smb://User:secret@computername/Receipt Printer");



            /* Print a "Hello world" receipt" */
            $printer = new Printer($connector);

            $cashouts=  DB::table('cashouts')
            ->where('cashouts.cashOutId', '=' , $cashOutId)
            ->get()->toArray();



              foreach ($cashouts as $cashout) {
                  $receiveBy =  $cashout->receiveBy;
                  $amount =  $cashout->amount;
                  $note =  $cashout->note;
                  $dateCreated =  $cashout->created_at;


                  $header ="CASHOUT";
                  //header
                  $printer -> setTextSize(2,2);
                  $printer -> setJustification(Printer::FONT_C);
                  $printer -> setJustification(Printer::JUSTIFY_CENTER);
                  $printer -> text("".$header."\n");
                  $printer -> text("\n \n \n");

                  $printer -> setTextSize(1,1);
                  $printer -> setJustification(Printer::FONT_C);
                  $printer -> setJustification(Printer::JUSTIFY_LEFT);
                  $printer -> text("Date:".$dateCreated."\n");
                  $printer -> text("\n");

                  $printer -> setTextSize(1,1);
                  $printer -> setJustification(Printer::FONT_C);
                  $printer -> setJustification(Printer::JUSTIFY_LEFT);
                  $printer -> text("Received By:".$receiveBy."\n");
                  $printer -> text("\n");

                  $printer -> setJustification(Printer::JUSTIFY_CENTER);
                  $line_dash = str_repeat("_", 40);
                  $printer -> text("" .$line_dash."\n");
                  $printer -> text("Signature Over Printed Name\n \n");


                  $printer -> setTextSize(1,1);
                  $printer -> setJustification(Printer::FONT_C);
                  $printer -> setJustification(Printer::JUSTIFY_LEFT);
                  $printer -> text("Amount:". number_format($amount, 2)."\n");
                  $printer -> text("\n");


                  $printer -> setTextSize(1,1);
                  $printer -> setJustification(Printer::FONT_C);
                  $printer -> setJustification(Printer::JUSTIFY_LEFT);
                  $printer -> text("Note:".$note."\n");
                  $printer -> text("\n");



              }





            $printer -> cut();

            /* Close printer */
            $printer -> close();
        } catch (Exception $e) {
        }

    }

    public function printCashInSave(Request $request){
        try {
            $device =DB::select("SELECT deviceName  FROM devices WHERE departmentId = 3");
            // Enter the share name for your printer here, as a smb:// url format
            $connector = new WindowsPrintConnector($device[0]->deviceName);
            // $connector = new WindowsPrintConnector("smb://DESKTOP-EN0ACJM/EPSON TM-T82X");
            //$connector = new WindowsPrintConnector("smb://FooUser:secret@computername/workgroup/Receipt Printer");
            //$connector = new WindowsPrintConnector("smb://User:secret@computername/Receipt Printer");



            /* Print a "Hello world" receipt" */
            $printer = new Printer($connector);



                    $givenBy =  $request->giveBy;
                    $amount =  $request->amount;
                    $note =  $request->note;
                    $dateCreated = now();


                  $header ="CASHIN";
                  //header
                  $printer -> setTextSize(2,2);
                  $printer -> setJustification(Printer::FONT_C);
                  $printer -> setJustification(Printer::JUSTIFY_CENTER);
                  $printer -> text("".$header."\n");
                  $printer -> text("\n \n \n");

                  $printer -> setTextSize(1,1);
                  $printer -> setJustification(Printer::FONT_C);
                  $printer -> setJustification(Printer::JUSTIFY_LEFT);
                  $printer -> text("Date:".$dateCreated."\n");
                  $printer -> text("\n");

                  $printer -> setTextSize(1,1);
                  $printer -> setJustification(Printer::FONT_C);
                  $printer -> setJustification(Printer::JUSTIFY_LEFT);
                  $printer -> text("Given By:".$givenBy."\n");
                  $printer -> text("\n");

                  $printer -> setJustification(Printer::JUSTIFY_CENTER);
                  $line_dash = str_repeat("_", 40);
                  $printer -> text("" .$line_dash."\n");
                  $printer -> text("Signature Over Printed Name\n \n");

                  $printer -> setTextSize(1,1);
                  $printer -> setJustification(Printer::FONT_C);
                  $printer -> setJustification(Printer::JUSTIFY_LEFT);
                  $printer -> text("Amount:". number_format($amount, 2)."\n");
                  $printer -> text("\n");

                  $printer -> setTextSize(1,1);
                  $printer -> setJustification(Printer::FONT_C);
                  $printer -> setJustification(Printer::JUSTIFY_CENTER);
                  $printer -> text("Note:".$note."\n");
                  $printer -> text("\n");


            $printer -> cut();

            /* Close printer */
            $printer -> close();
        } catch (Exception $e) {
        }
    }

    public function printCashOutSave(Request $request){
        try {
            $device =DB::select("SELECT deviceName  FROM devices WHERE departmentId = 3");
            // Enter the share name for your printer here, as a smb:// url format
            $connector = new WindowsPrintConnector($device[0]->deviceName);
            // $connector = new WindowsPrintConnector("smb://DESKTOP-EN0ACJM/EPSON TM-T82X");
            //$connector = new WindowsPrintConnector("smb://FooUser:secret@computername/workgroup/Receipt Printer");
            //$connector = new WindowsPrintConnector("smb://User:secret@computername/Receipt Printer");



            /* Print a "Hello world" receipt" */
            $printer = new Printer($connector);



                  $receiveBy =   $request->receiveBy;
                  $amount =   $request->amount;
                  $note =   $request->note;
                  $dateCreated =  now();


                  $header ="CASHOUT";
                  //header
                  $printer -> setTextSize(2,2);
                  $printer -> setJustification(Printer::FONT_C);
                  $printer -> setJustification(Printer::JUSTIFY_CENTER);
                  $printer -> text("".$header."\n");
                  $printer -> text("\n \n \n");

                  $printer -> setTextSize(1,1);
                  $printer -> setJustification(Printer::FONT_C);
                  $printer -> setJustification(Printer::JUSTIFY_LEFT);
                  $printer -> text("Date:".$dateCreated."\n");
                  $printer -> text("\n");

                  $printer -> setTextSize(1,1);
                  $printer -> setJustification(Printer::FONT_C);
                  $printer -> setJustification(Printer::JUSTIFY_LEFT);
                  $printer -> text("Received By:".$receiveBy."\n");
                  $printer -> text("\n");

                  $printer -> setJustification(Printer::JUSTIFY_CENTER);
                  $line_dash = str_repeat("_", 40);
                  $printer -> text("" .$line_dash."\n");
                  $printer -> text("Signature Over Printed Name\n \n");


                  $printer -> setTextSize(1,1);
                  $printer -> setJustification(Printer::FONT_C);
                  $printer -> setJustification(Printer::JUSTIFY_LEFT);
                  $printer -> text("Amount:". number_format($amount, 2)."\n");
                  $printer -> text("\n");


                  $printer -> setTextSize(1,1);
                  $printer -> setJustification(Printer::FONT_C);
                  $printer -> setJustification(Printer::JUSTIFY_LEFT);
                  $printer -> text("Note:".$note."\n");
                  $printer -> text("\n");


            $printer -> cut();

            /* Close printer */
            $printer -> close();
        } catch (Exception $e) {
        }

    }

    public function printBillout(Request $request) {
        $transactionId = $request->transactionId;
        try {
            $device = DB::select("SELECT deviceName  FROM devices WHERE departmentId = 3");
            $connector = new WindowsPrintConnector($device[0]->deviceName);
            $printer = new Printer($connector);

            $transaction = DB::table('transactions')
                ->join('tables', 'transactions.transactionTableId', '=', 'tables.tableId')
                ->select('tableName')
                ->where('transactionId', $transactionId)
                ->first();

            $orders = DB::table('orders')
                ->join('items', 'orders.itemId', '=', 'items.itemId')
                ->where('transactionId', $transactionId)
                ->get();
            $order_items = [];
            if(count($orders) > 0) {
                foreach($orders as $order) {
                    array_push($order_items, [
                        'Item' => $order->itemName,
                        'Qty' => $order->orderQty,
                        'Total' => number_format($order->orderTotal, 2, '.', ',')
                    ]);
                }
            }

            // space before total
            array_push($order_items, [
                'Item' => "\n",
                'Qty' => "\n",
                'Total' => ""
            ]);

            $total_price = DB::table('orders')->where('transactionId', $transactionId)->sum('orderTotal');
            array_push($order_items, [
                'Item' => 'TOTAL',
                'Qty' => '',
                'Total' => number_format($total_price, 2, '.', ',')
            ]);

            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_C);
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $printer -> text($transaction->tableName);
            $printer -> text("\n");

            $printer -> setTextSize(1,1);
            $printer -> setJustification(Printer::FONT_C);
            $printer -> setJustification(Printer::JUSTIFY_CENTER);
            $printer -> text(texttable::table($order_items));
            $printer -> cut();
            $printer -> close();

            return response('Billout success', 200);
        } catch(Exception $e) {
            return response('200', 'Printer not found');
        }
    }
}
