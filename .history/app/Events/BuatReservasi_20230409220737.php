<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BuatReservasi implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public $message="Pengajuan Konseling Masuk";
    public $nama;
    public $kelas;
    public $tanggal;
    public $jamke;
    public $keterangan;
    public $id_konselor;

    
    public function __construct($nama,$kelas,$tanggal,$jamke,$keterangan,$id_konselor)
    {
        $this->nama=$nama;
        $this->kelas=$kelas;
        $this->tanggal=$tanggal;
        $this->jamke=$jamke;
        $this->keterangan=$keterangan;
        $this->id_konselor = $id_konselor;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('pesanreservasi.'.$this->id_konselor);
    }
}
