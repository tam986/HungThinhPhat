"use client";

import { motion } from "framer-motion";
import { Mail, Phone, MapPin, Send, History, Heart, ShieldCheck } from "lucide-react";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { toast } from "sonner";
import { useState } from "react";

export default function AboutUs() {
  const [isSending, setIsSending] = useState(false);

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    setIsSending(true);
    // Simulate API call
    setTimeout(() => {
      setIsSending(false);
      toast.success("Cảm ơn bạn! Tin nhắn của bạn đã được gửi thành công.");
      (e.target as HTMLFormElement).reset();
    }, 1500);
  };

  return (
    <div className="min-h-screen pt-24 pb-16 bg-white overflow-hidden">
      {/* Hero Section */}
      <section className="relative h-[500px] flex items-center justify-center text-center px-4 overflow-hidden">
        <div className="absolute inset-0 z-0">
          <div className="absolute inset-0 bg-black/40 z-10" />
          <img 
            src="https://images.unsplash.com/photo-1556910103-1c02745aae4d?auto=format&fit=crop&q=80" 
            alt="Hero Background" 
            className="w-full h-full object-cover"
          />
        </div>
        
        <motion.div 
          initial={{ opacity: 0, y: 30 }}
          animate={{ opacity: 1, y: 0 }}
          className="relative z-20 space-y-6 max-w-4xl"
        >
          <h1 className="text-5xl md:text-7xl font-merriweather font-bold text-white leading-tight">
            Khát vọng mang đặc sản <br /> 
            <span className="text-primary italic">Miền Tây đi muôn phương</span>
          </h1>
          <p className="text-white/90 text-xl font-medium max-w-2xl mx-auto border-l-4 border-primary pl-4">
            Hưng Thịnh Food - Hành trình chắt lọc tinh hoa từ vùng đất phù sa trù phú, mang hương vị quê nhà đến mọi bàn ăn Việt.
          </p>
        </motion.div>
      </section>

      {/* History & Story */}
      <section className="container mx-auto px-4 py-24">
        <div className="grid lg:grid-cols-2 gap-16 items-center">
          <motion.div 
             initial={{ opacity: 0, x: -50 }}
             whileInView={{ opacity: 1, x: 0 }}
             viewport={{ once: true }}
             className="space-y-8"
          >
            <div className="space-y-2">
              <span className="text-primary font-bold uppercase tracking-[0.2em] text-sm">Câu chuyện Hưng Thịnh</span>
              <h2 className="text-4xl md:text-5xl font-merriweather font-bold leading-tight">Từ đôi bàn tay khéo léo và tình yêu quê hương</h2>
            </div>
            
            <div className="space-y-6 text-muted-foreground text-lg leading-relaxed">
              <p>
                Ra đời từ năm 2015 tại thủ phủ các loại bánh kẹo Miền Tây, Hưng Thịnh Food khởi đầu là một xưởng sản xuất gia đình nhỏ với mong muốn bảo tồn những công thức gia truyền của các loại Bánh Pía, Lạp Xưởng, và Kẹo Dừa.
              </p>
              <p>
                Với phương châm "Thực phẩm từ tâm", chúng tôi không ngừng cải tiến quy trình sản xuất nhưng vẫn giữ trọn các bước thủ công quan trọng để đảm bảo hương vị nguyên bản. Mỗi sản phẩm của Hưng Thịnh Food không chỉ là thực phẩm, mà là một lời chào nồng hậu từ miền Tây sông nước.
              </p>
            </div>

            <div className="grid grid-cols-3 gap-8 pt-8">
              <div className="text-center space-y-2">
                <div className="w-12 h-12 bg-primary/10 rounded-full flex items-center justify-center mx-auto text-primary">
                  <History className="w-6 h-6" />
                </div>
                <p className="font-bold text-2xl">9+</p>
                <p className="text-xs text-muted-foreground">Năm kinh nghiệm</p>
              </div>
              <div className="text-center space-y-2">
                <div className="w-12 h-12 bg-primary/10 rounded-full flex items-center justify-center mx-auto text-primary">
                  <Heart className="w-6 h-6" />
                </div>
                <p className="font-bold text-2xl">50k+</p>
                <p className="text-xs text-muted-foreground">Khách hàng tin dùng</p>
              </div>
              <div className="text-center space-y-2">
                <div className="w-12 h-12 bg-primary/10 rounded-full flex items-center justify-center mx-auto text-primary">
                  <ShieldCheck className="w-6 h-6" />
                </div>
                <p className="font-bold text-2xl">100%</p>
                <p className="text-xs text-muted-foreground">An toàn vệ sinh</p>
              </div>
            </div>
          </motion.div>

          <motion.div 
            initial={{ opacity: 0, scale: 0.9 }}
            whileInView={{ opacity: 1, scale: 1 }}
            viewport={{ once: true }}
            className="relative"
          >
            <div className="aspect-[4/5] rounded-[60px] overflow-hidden shadow-2xl relative z-10 border-8 border-white">
              <img 
                src="https://images.unsplash.com/photo-1542831371-29b0f74f9713?auto=format&fit=crop&q=80" 
                alt="Our values" 
                className="w-full h-full object-cover"
              />
            </div>
            <div className="absolute -bottom-10 -right-10 w-64 h-64 bg-primary/10 rounded-full blur-3xl z-0" />
            <div className="absolute -top-10 -left-10 w-48 h-48 bg-primary/20 rounded-full blur-2xl z-0" />
          </motion.div>
        </div>
      </section>

      {/* Contact Section */}
      <section className="bg-neutral-900 py-24 relative overflow-hidden">
        <div className="container mx-auto px-4 relative z-10">
          <div className="bg-white rounded-[40px] overflow-hidden shadow-2xl grid lg:grid-cols-2">
            {/* Contact Info */}
            <div className="p-12 md:p-20 bg-primary text-white space-y-12">
              <div className="space-y-4">
                <h2 className="text-4xl font-merriweather font-bold">Kết nối với chúng tôi</h2>
                <p className="text-white/70">Chúng tôi luôn lắng nghe ý kiến đóng góp từ bạn.</p>
              </div>

              <div className="space-y-8">
                <div className="flex items-start gap-6">
                  <div className="w-12 h-12 bg-white/10 rounded-2xl flex items-center justify-center shrink-0">
                    <MapPin className="w-6 h-6" />
                  </div>
                  <div>
                    <h4 className="font-bold text-lg">Địa chỉ Trụ sở</h4>
                    <p className="text-white/70">Số 123 Đường Phù Sa, Phường Ninh Kiều, TP. Cần Thơ</p>
                  </div>
                </div>

                <div className="flex items-start gap-6">
                  <div className="w-12 h-12 bg-white/10 rounded-2xl flex items-center justify-center shrink-0">
                    <Phone className="w-6 h-6" />
                  </div>
                  <div>
                    <h4 className="font-bold text-lg">Hotline</h4>
                    <p className="text-white/70">0123 456 789 (Hỗ trợ 24/7)</p>
                  </div>
                </div>

                <div className="flex items-start gap-6">
                  <div className="w-12 h-12 bg-white/10 rounded-2xl flex items-center justify-center shrink-0">
                    <Mail className="w-6 h-6" />
                  </div>
                  <div>
                    <h4 className="font-bold text-lg">Email</h4>
                    <p className="text-white/70">lienhe@hungthinhfood.com</p>
                  </div>
                </div>
              </div>

              <div className="pt-12 border-t border-white/10">
                <p className="text-sm">Hưng Thịnh Food - Thương hiệu được bảo hộ bởi Hưng Thịnh Phat Corp.</p>
              </div>
            </div>

            {/* Contact Form */}
            <div className="p-12 md:p-20 space-y-10">
              <div className="space-y-2">
                <h3 className="text-3xl font-bold font-merriweather">Gửi lời nhắn</h3>
                <p className="text-muted-foreground">Để lại thông tin, chúng tôi sẽ phản hồi trong vòng 24h.</p>
              </div>

              <form onSubmit={handleSubmit} className="space-y-6">
                <div className="grid md:grid-cols-2 gap-4">
                  <div className="space-y-2">
                    <label className="text-xs font-bold uppercase tracking-wider text-muted-foreground">Họ tên</label>
                    <Input placeholder="Nguyễn Văn A" className="h-14 rounded-2xl border-2 focus:border-primary" required />
                  </div>
                  <div className="space-y-2">
                    <label className="text-xs font-bold uppercase tracking-wider text-muted-foreground">Email</label>
                    <Input type="email" placeholder="example@gmail.com" className="h-14 rounded-2xl border-2 focus:border-primary" required />
                  </div>
                </div>
                <div className="space-y-2">
                  <label className="text-xs font-bold uppercase tracking-wider text-muted-foreground">Chủ đề</label>
                  <Input placeholder="Hỗ trợ kỹ thuật / Góp ý sản phẩm" className="h-14 rounded-2xl border-2 focus:border-primary" />
                </div>
                <div className="space-y-2">
                  <label className="text-xs font-bold uppercase tracking-wider text-muted-foreground">Nội dung tin nhắn</label>
                  <textarea 
                    placeholder="Lời nhắn của bạn..." 
                    className="flex min-h-[150px] w-full rounded-[30px] border-2 border-input bg-background p-6 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-primary focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 focus:border-primary" 
                    required 
                  />
                </div>
                <Button 
                  disabled={isSending} 
                  className="w-full h-16 rounded-[30px] bg-primary hover:bg-primary/90 text-white font-bold text-lg gap-2 shadow-xl shadow-primary/20"
                >
                  {isSending ? (
                    <span className="w-6 h-6 border-2 border-white/30 border-t-white rounded-full animate-spin" />
                  ) : (
                    <>
                      Gửi tin nhắn ngay
                      <Send className="w-5 h-5" />
                    </>
                  )}
                </Button>
              </form>
            </div>
          </div>
        </div>
      </section>
    </div>
  );
}
