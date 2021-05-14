<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <?php
        require_once("Class/ABApay.php");
        require_once("Class/PiPay.php");
        require_once("Class/Wingpay.php");

        class Transaction{
            private $item;
            private $quantity;
            private $unit_price;
            private $total_price;
            public function __construct($item, $quantity, $unit_price){
                $this -> item = $item;
                $this -> quantity = $quantity;
                $this -> unit_price = $unit_price;
                $this -> total_price = $unit_price * $quantity;
            }
    
            public function getStuff(){
                return $this -> item;
            }
    
            public function getUnitPrice(){
                return $this->unit_price;
            }
    
            public function getQuantity(){
                return $this->quantity;
            }
    
            public function getTotalPrice(){
                return $this -> total_price;
            }
        }
        
        class PaymentRecord{
            private $transaction_detail;
            private $transaction_method;

            public function __construct($transaction_detail, $transaction_method){
                $this->transaction_detail = $transaction_detail;
                $this->transaction_method = $transaction_method;
            }

            public function getTransactionDetail(){
                return $this->transaction_detail;
            }
            public function getTransactionMethod(){
                return $this->transaction_method;
            }
        }

        $item_1 = new Transaction("item1", 1, 5);
        $item_2 = new Transaction("item2", 2, 3);
        $item_3 = new Transaction("item3", 1, 4);
        $item_4 = new Transaction("item4", 1, 5);
        $item_5 = new Transaction("item5", 1, 6);
        $item_6 = new Transaction("item6", 1, 10);
        $item_7 = new Transaction("item7", 1, 15);
        $item_8 = new Transaction("item8", 1, 2);

        class PaymentService{
            private $abaPaymentGateway;
            private $wingPaymentGateway;
            private $pipayPaymentGateway;
            private $paymentRecords = [];

            public function __construct(){
                $this->abaPaymentGateway = new ABA();
                $this->wingPaymentGateway = new Wing();
                $this->pipayPaymentGateway = new PiPaY();
            }

            public function payABA($transaction){
                $this->abaPaymentGateway->charge($transaction);
                ($this -> paymentRecords)[] = new PaymentRecord($transaction, "ABA");
            }

            public function payWing($transaction){
                $this -> wingPaymentGateway -> charge($transaction);
                ($this -> paymentRecords)[] =  new PaymentRecord($transaction, "Wing");
            }

            public function payPipay($transaction){
                $this -> pipayPaymentGateway -> charge($transaction);
                ($this -> paymentRecords)[] =  new PaymentRecord($transaction, "PiPay");          
            }
            
            public function getPaymentRecords(){
                return $this->paymentRecords;
            }

            public function getSortedPaymentRecordsByTotalPrice(){
                $sorted_paymentRecords = $this->paymentRecords;
                usort($sorted_paymentRecords, fn($a, $b) => $a->getTransactionDetail()->getTotalPrice() < $b->getTransactionDetail()->getTotalPrice());
                return $sorted_paymentRecords;
            }


            public function displayPayment($paymentRecords){
                echo "
                    <table>
                    <tr >
                    <th>Name</th>
                    <th>Price</th> 
                    <th>Quantity</th>
                    <th>Methods</th>
                    <th>Total</th>
                    </tr>";
                foreach($paymentRecords as $record){
                    echo "<tr>
                    <td>{$record -> getTransactionDetail() -> getStuff()}</td>
                    <td>{$record -> getTransactionDetail() -> getUnitPrice()}</td>
                    <td>{$record -> getTransactionDetail() -> getQuantity()}</td>
                    <td>{$record -> getTransactionMethod()}</td>
                    <td>{$record -> getTransactionDetail() -> getTotalPrice()}</td>
                    </tr>";
                }
            }

            public function getPaymentRecordsByTransactionMethod($transaction_method){
                return array_filter($this->paymentRecords, fn($paymentRecord) => $paymentRecord->getTransactionMethod() == $transaction_method);
            }

            public function getPaymentRecordsByTransactionMethods(...$transaction_methods){
                return array_filter($this->paymentRecords, fn($paymentRecord) => in_array($paymentRecord->getTransactionMethod(),$transaction_methods));
            }

        }

        
        $paymentService = new PaymentService();

        $paymentService -> payABA($item_1);
        $paymentService -> payWing($item_2);
        $paymentService -> payABA($item_3);
        $paymentService -> payABA($item_4);
        $paymentService -> payPipay($item_5);
        $paymentService -> payABA($item_6);
        $paymentService -> payWing($item_7);
        $paymentService -> payWing($item_8);


        
        $paymentService -> displayPayment($paymentService -> getPaymentRecords());
        $paymentService -> displayPayment($paymentService -> getPaymentRecordsByTransactionMethod("ABA"));
        $paymentService -> displayPayment($paymentService -> getPaymentRecordsByTransactionMethods("PiPay","Wing"));
        $paymentService -> displayPayment($paymentService -> getSortedPaymentRecordsByTotalPrice());
    ?>
</body>
</html>