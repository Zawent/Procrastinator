package co.edu.procastinadont;


import android.app.Service;
import android.content.Intent;
import android.graphics.PixelFormat;
import android.os.Build;
import android.os.IBinder;
import android.view.Gravity;
import android.view.LayoutInflater;
import android.view.View;
import android.view.WindowManager;
import android.widget.TextView;
import androidx.annotation.Nullable;


public class BloqueoService extends Service {

    private WindowManager windowManager;
    private View bloqueoView;
    private String selectedAppName;
    private String AppPrimerPlano;
    private int selectedTime;



    @Override
    public void onCreate() {

        super.onCreate();
        windowManager = (WindowManager) getSystemService(WINDOW_SERVICE);
    }

    @Override
    public int onStartCommand(Intent intent, int flags, int startId) {
        if (intent != null) {
            selectedAppName = intent.getStringExtra("NombreApp");
            selectedTime = intent.getIntExtra("TiempoBloqueo", 0);
            AppPrimerPlano = intent.getStringExtra("AppPrimerPlano");

            if (AppPrimerPlano != null && AppPrimerPlano.equals(selectedAppName)) {
                IniciarBloqueo();
            }
        }
        return START_NOT_STICKY;
    }


    private void IniciarBloqueo() {
        bloqueoView = LayoutInflater.from(this).inflate(R.layout.bloqueado, null);

        WindowManager.LayoutParams params;
        if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.O) {
            params = new WindowManager.LayoutParams(
                    WindowManager.LayoutParams.MATCH_PARENT,
                    WindowManager.LayoutParams.WRAP_CONTENT,
                    WindowManager.LayoutParams.TYPE_APPLICATION_OVERLAY,
                    WindowManager.LayoutParams.FLAG_NOT_FOCUSABLE,
                    PixelFormat.TRANSLUCENT);
        } else {
            params = new WindowManager.LayoutParams(
                    WindowManager.LayoutParams.MATCH_PARENT,
                    WindowManager.LayoutParams.WRAP_CONTENT,
                    WindowManager.LayoutParams.TYPE_PHONE,
                    WindowManager.LayoutParams.FLAG_NOT_FOCUSABLE,
                    PixelFormat.TRANSLUCENT);
        }

        params.gravity = Gravity.CENTER;

        windowManager.addView(bloqueoView, params);

        TextView textView = bloqueoView.findViewById(R.id.BloqueoText);
        textView.setText("Aplicación bloqueada: " + selectedAppName);

        bloqueoView.postDelayed(new Runnable() {
            @Override
            public void run() {
                DetenerBloqueo();
            }
        }, selectedTime * 60 * 1000);

    }


    private void DetenerBloqueo() {
        if (bloqueoView != null && bloqueoView.getWindowToken() != null) {
            windowManager.removeView(bloqueoView);
        }
        stopSelf();
    }

    @Nullable
    @Override
    public IBinder onBind(Intent intent) {
        return null;
    }

    @Override
    public void onDestroy() {
        DetenerBloqueo();
        super.onDestroy();
    }
}
