import { Input } from "@/components/ui/input";
import { Button } from "@/components/ui/button";
import { SiVisa, SiMastercard, SiPaypal } from "react-icons/si";

export function Footer() {
  return (
    <footer className="bg-card border-t mt-16">
      <div className="max-w-7xl mx-auto px-4 py-12">
        <div className="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
          <div className="space-y-4">
            <h3 className="font-bold text-lg font-mono">TechStore</h3>
            <p className="text-sm text-muted-foreground">
              Nguồn cung cấp máy tính, laptop và linh kiện cao cấp đáng tin cậy.
            </p>
          </div>

          <div className="space-y-3">
            <h4 className="font-semibold">Mua Sắm</h4>
            <ul className="space-y-2 text-sm">
              <li>
                <a href="#" className="text-muted-foreground hover:text-foreground">
                  Máy Tính Để Bàn
                </a>
              </li>
              <li>
                <a href="#" className="text-muted-foreground hover:text-foreground">
                  Laptop
                </a>
              </li>
              <li>
                <a href="#" className="text-muted-foreground hover:text-foreground">
                  Linh Kiện
                </a>
              </li>
              <li>
                <a href="#" className="text-muted-foreground hover:text-foreground">
                  Thiết Bị Ngoại Vi
                </a>
              </li>
            </ul>
          </div>

          <div className="space-y-3">
            <h4 className="font-semibold">Hỗ Trợ</h4>
            <ul className="space-y-2 text-sm">
              <li>
                <a href="#" className="text-muted-foreground hover:text-foreground">
                  Liên Hệ
                </a>
              </li>
              <li>
                <a href="#" className="text-muted-foreground hover:text-foreground">
                  Thông Tin Vận Chuyển
                </a>
              </li>
              <li>
                <a href="#" className="text-muted-foreground hover:text-foreground">
                  Đổi Trả
                </a>
              </li>
              <li>
                <a href="#" className="text-muted-foreground hover:text-foreground">
                  Bảo Hành
                </a>
              </li>
            </ul>
          </div>

          <div className="space-y-3">
            <h4 className="font-semibold">Nhận Tin</h4>
            <p className="text-sm text-muted-foreground">
              Giảm 10% cho đơn hàng đầu tiên
            </p>
            <div className="flex gap-2">
              <Input
                type="email"
                placeholder="Email của bạn"
                className="flex-1"
                data-testid="input-newsletter"
              />
              <Button data-testid="button-subscribe">Đăng Ký</Button>
            </div>
          </div>
        </div>

        <div className="border-t pt-8 flex flex-col md:flex-row items-center justify-between gap-4">
          <p className="text-sm text-muted-foreground">
            © 2025 TechStore. Bản quyền thuộc về TechStore.
          </p>
          <div className="flex items-center gap-4">
            <span className="text-sm text-muted-foreground">Chấp nhận:</span>
            <div className="flex items-center gap-3">
              <SiVisa className="h-8 w-auto text-foreground" />
              <SiMastercard className="h-8 w-auto text-foreground" />
              <SiPaypal className="h-8 w-auto text-foreground" />
            </div>
          </div>
        </div>
      </div>
    </footer>
  );
}
