package co.edu.procastinadont;


import android.app.Service;
import android.content.Intent;
import android.graphics.PixelFormat;
import android.nfc.Tag;
import android.os.Build;
import android.os.IBinder;
import android.view.Gravity;
import android.view.LayoutInflater;
import android.view.View;
import android.view.WindowManager;
import android.widget.TextView;
import androidx.annotation.Nullable;
import android.os.CountDownTimer;
import androidx.localbroadcastmanager.content.LocalBroadcastManager;
import java.util.Timer;
import java.util.TimerTask;
import android.util.Log;





public class BloqueoService extends Service {

    private Timer timer;
    private WindowManager windowManager;
    private View bloqueoView;
    private String selectedAppName;
    private String AppPrimerPlano;
    private int selectedTime;
    private CountDownTimer time;
    private int tiempoRestante;
    private static final String TAG = "tag";


    @Override
        public void onCreate() {
            super.onCreate();
            windowManager = (WindowManager) getSystemService(WINDOW_SERVICE);
            timer = new Timer();
            timer.scheduleAtFixedRate(new TimerTask() {
                @Override
                public void run() {
                    verificarAppEnPrimerPlano();
                }
            }, 0, 1000);
        }

    @Override
    public int onStartCommand(Intent intent, int flags, int startId) {
        if (intent != null) {
            selectedAppName = intent.getStringExtra("NombreApp");
            selectedTime = intent.getIntExtra("TiempoBloqueo", 0);
            AppPrimerPlano = intent.getStringExtra("AppPrimerPlano");
            tiempoRestante = intent.getIntExtra("TiempoBloqueo", 0);

            iniciarTemporizador();

        }
        return START_NOT_STICKY;
    }

    private void verificarAppEnPrimerPlano() {
        if (AppPrimerPlano != null && AppPrimerPlano.equals(selectedAppName)) {
            IniciarBloqueo();
        } else {
            Log.i(TAG,"No sirveee");
            Log.i(TAG,"App"+AppPrimerPlano);
        }
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
        if (bloqueoView != null && bloqueoView.getWindowToken() != null && AppPrimerPlano != null && AppPrimerPlano.equals(selectedAppName)) {
            windowManager.removeView(bloqueoView);
            bloqueoView = null;
        }
    }


    private void iniciarTemporizador() {
        time = new CountDownTimer(tiempoRestante * 60 * 1000, 1000) {
            @Override
            public void onTick(long millisUntilFinished) {
                tiempoRestante = (int) (millisUntilFinished / 1000);
                Intent intent = new Intent("TIEMPO_RESTANTE");
                intent.putExtra("tiempoRestante", tiempoRestante);
                LocalBroadcastManager.getInstance(BloqueoService.this).sendBroadcast(intent);
            }

            @Override
            public void onFinish() {
                stopSelf();
            }
        }.start();
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
