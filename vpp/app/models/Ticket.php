<?php


use Illuminate\Cache\MemcachedStore;

class Ticket extends Eloquent {

    /**
     * The database table admin by the model.

    `ticket_rate` varchar(255) DEFAULT NULL COMMENT 'Tỷ giá ngoại tệ',
    `ticket_rate_money` varchar(255) DEFAULT NULL COMMENT 'số tiền quy đổi tỷ giá ngoại tệ',
    `ticket_time_created` int(11) DEFAULT NULL COMMENT 'Ngày tạo phiếu',
    `ticket_time_approve` int(11) DEFAULT NULL COMMENT 'Ngày duyệt phiếu',
    `ticket_date_created` int(11) DEFAULT NULL,
    `ticket_user_created` varchar(255) DEFAULT NULL,
    `ticket_user_id_created` int(11) DEFAULT NULL,
    `ticket_date_update` int(11) DEFAULT NULL,
    `ticket_user_update` varchar(255) NOT NULL,
    `ticket_user_id_update` int(11) DEFAULT NULL,
    PRIMARY KEY (`ticket_id`)
    ) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;
     */
    protected $table = 'ticket';
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'ticket_id';

    public $timestamps = false;
    //Mass assignment

    // define which attributes are mass assignable (for security)
    protected $fillable = array('ticket_type',
        'ticket_company','ticket_company_address','ticket_company_mst','ticket_book_number',
        'ticket_number','ticket_miss','ticket_acttack','ticket_person_money','ticket_person_address',
        'ticket_reason','ticket_money','ticket_money_pay','ticket_money_miss','ticket_file_acttack','ticket_file_root',
        'ticket_rate','ticket_rate_money','ticket_time_created','ticket_time_approve',
        'ticket_date_created','ticket_user_created','ticket_user_id_created',
        'ticket_date_update','ticket_user_update','ticket_user_id_update',
    );

    /**
     * @param $id
     * @return mixed
     */
    public static function getTicketById($id){
        $ticket = Ticket::find($id);
        return $ticket;
    }

    public static function searchByCondition($data = array(), $limit = 0, $offset = 0, &$size)
    {
        try {
            $query = Ticket::where('ticket_id', '>', 0);
            if (isset($data['ticket_type']) && $data['ticket_type'] > 0) {
                $query->where('ticket_type', $data['ticket_type']);
            }
            if (isset($data['ticket_person_money']) && $data['ticket_person_money'] != '') {
                $query->where('ticket_person_money', 'LIKE', '%' . $data['ticket_person_money'] . '%');
            }

            if ($data['ticket_time_created_start'] != '') {
                $query->where('ticket_time_created', '>=', strtotime($data['ticket_time_created_start']));
            }
            if ($data['ticket_time_created_end'] != '') {
                $query->where('ticket_time_created', '<=', strtotime($data['ticket_time_created_end']));
            }

            if ($data['ticket_time_approve_start'] != '') {
                $query->where('ticket_time_approve', '>=', strtotime($data['ticket_time_approve_start']));
            }
            if ($data['ticket_time_approve_end'] != '') {
                $query->where('ticket_time_approve', '<=', strtotime($data['ticket_time_approve_end']));
            }
            $size = $query->count();
            $data = $query->orderBy('ticket_id', 'desc')->take($limit)->skip($offset)->get();
            return $data;
        } catch (PDOException $e) {
            $size = 0;
            return null;
            throw new PDOException();
        }
    }

    public static function createNew($data)
    {
        try {
            DB::connection()->getPdo()->beginTransaction();
            $ticket = new Ticket();
            if (is_array($data) && count($data) > 0) {
                foreach ($data as $k => $v) {
                    $ticket->$k = $v;
                }
            }
            $ticket->save();

            DB::connection()->getPdo()->commit();
            return $ticket->ticket_id;
        } catch (PDOException $e) {
            //var_dump($e->getMessage());die;
            DB::connection()->getPdo()->rollBack();
            throw new PDOException();
        }
    }

    public static function updateTicket($id,$data){
        try {
            DB::connection()->getPdo()->beginTransaction();
            $ticket = Ticket::find($id);
            foreach ($data as $k => $v) {
                $ticket->$k = $v;
            }
            $ticket->update();
            DB::connection()->getPdo()->commit();
            return true;
        } catch (PDOException $e) {
            //var_dump($e->getMessage());
            DB::connection()->getPdo()->rollBack();
            throw new PDOException();
        }
    }

    public static function remove($ticket){
        try {
            DB::connection()->getPdo()->beginTransaction();
            $ticket->delete();
            DB::connection()->getPdo()->commit();
            return true;
        } catch (PDOException $e) {
            //var_dump($e->getMessage());
            DB::connection()->getPdo()->rollBack();
            throw new PDOException();
            return false;
        }
    }


}
