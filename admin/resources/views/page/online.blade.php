<ul class="list-group mt-3">
        @php
        $usersOnline = $users->filter(function($u) {
            return $u->last_login;
        });
    
        $usersOffline = $users->filter(function($u) {
            return !$u->last_login && $u->last_logout;
        });
    @endphp
    <div class="accordion accordion-flush" id="accordionFlushExample">
      <div class="accordion-item">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
           <h5>Đang Online</h5>
          </button>
        </h2>
        <div id="flush-collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
          <div class="accordion-body">  @forelse ($usersOnline as $user)
        <li class="list-group-item border-0 d-flex align-items-center py-2">
            <img class="rounded-circle me-3"
                src="{{ $user->hinh ? asset('uploads/' . $user->hinh) : asset('img-user/_default-user.png') }}"
                alt="User Avatar" style="width: 40px; height: 40px; object-fit: cover;">
            <div class="user-info d-flex flex-column">
                <span class="fw-bold">{{ $user->hoten }}</span>
                <small class="text-success">Đang online</small>
            </div>
            <span class="status-indicator ms-auto online"></span>
        </li>
    @empty
        <li class="list-group-item border-0 text-muted py-2">Không có người dùng nào đang online</li>
    @endforelse</div>
        </div>
      </div>
      <div class="accordion-item">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
              <h5 class="mt-4">Đang Offline</h5>
          </button>
        </h2>
        <div id="flush-collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
          <div class="accordion-body"> @forelse ($usersOffline as $user)
        <li class="list-group-item border-0 d-flex align-items-center py-2">
            <img class="rounded-circle me-3"
                src="{{ $user->hinh ? asset('uploads/' . $user->hinh) : asset('img-user/_default-user.png') }}"
                alt="User Avatar" style="width: 40px; height: 40px; object-fit: cover;">
            <div class="user-info d-flex flex-column">
                <span class="fw-bold">{{ $user->hoten }}</span>
                <small class="text-muted">
                    {{ \Carbon\Carbon::parse($user->last_logout)->diffForHumans() }} trước
                </small>
            </div>
            <span class="status-indicator ms-auto offline"></span>
        </li>
    @empty
        <li class="list-group-item border-0 text-muted py-2">Không có người dùng nào offline</li>
    @endforelse
   .</div>
        </div>
      </div>
    </div>
    
 

   

  
   
</ul>


<!-- CSS -->
<style>
    .status-indicator {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        display: inline-block;
    }

    .online {
        background-color: green;
        /* Online */
    }

    .offline {
        background-color: gray;
        /* Offline */
    }

    .text-success {
        color: green;
        /* Hiển thị thời gian online */
    }

    .text-muted {
        color: gray;
        /* Hiển thị thời gian offline */
    }

    .text-secondary {
        color: #aaa;
        /* Màu cho user chưa đăng nhập */
    }
</style>
