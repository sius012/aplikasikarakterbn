<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BuatReservasi
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public $judul = "Pengajuan Konseling Masuk";
    public $nama;
    public $kelas;
    public $tanggal;
    public $jamke;
    public $keterangan;

    public function __construct($nama,$kelas)
    {
        $this->nama=$nama;
        $this->kelas=$kelas;
        $this->tanggal=$tanggal;
        $this->jamke=$jamke;
        $this->keterangan=$dari
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
