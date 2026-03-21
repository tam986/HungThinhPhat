import { Truck, Ticket, HeartHandshake, ShieldCheck } from "lucide-react";

export function ServiceSection() {
  const services = [
    {
      icon: <Truck className="w-10 h-10 text-primary" />,
      title: "Miễn phí giao hàng",
      desc: "Miễn phí giao hàng cho tất cả đơn hàng."
    },
    {
      icon: <Ticket className="w-10 h-10 text-primary" />,
      title: "Voucher xịn xò",
      desc: "Nhiều mã giảm giá hấp dẫn mỗi tuần."
    },
    {
      icon: <HeartHandshake className="w-10 h-10 text-primary" />,
      title: "Dịch vụ ân cần",
      desc: "Luôn sẵn sàng hỗ trợ khách hàng 24/7."
    },
    {
      icon: <ShieldCheck className="w-10 h-10 text-primary" />,
      title: "Bảo mật thanh toán",
      desc: "100% giao dịch được bảo mật an toàn."
    }
  ];

  return (
    <section className="py-12 bg-white rounded-3xl shadow-sm border border-border/40">
      <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 px-8">
        {services.map((service, index) => (
          <div key={index} className="flex flex-col items-center text-center space-y-4">
            <div className="p-4 bg-primary/5 rounded-2xl">
              {service.icon}
            </div>
            <div className="space-y-1">
              <h4 className="font-bold text-lg text-foreground">{service.title}</h4>
              <p className="text-sm text-muted-foreground leading-relaxed">
                {service.desc}
              </p>
            </div>
          </div>
        ))}
      </div>
    </section>
  );
}
